<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PublicUser;
use App\Models\MCMCStaff;
use App\Models\Agency;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('UserLogin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:public,mcmc,agency'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'User not found.']);
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        if ($user->userType !== $request->role) {
            return back()->withErrors(['role' => 'Selected role does not match your account role.']);
        }

        Auth::login($user);

        // Debug log
        logger('Login success for ' . $user->username . ' as ' . $user->userType);

        // Auto-insert into subclass table based on role
        switch ($user->userType) {
            case 'public':
                if (!PublicUser::where('userID', $user->userID)->exists()) {
                    PublicUser::create([
                        'userID' => $user->userID,
                        'publicUserID' => $user->userID, // Using userID for subclass ID, modify if needed
                        'publicUserAge' => 25 // Placeholder age, adjust as required
                    ]);
                }
                break;

            case 'mcmc':
                if (!MCMCStaff::where('userID', $user->userID)->exists()) {
                    MCMCStaff::create([
                        'userID' => $user->userID,
                        'MCMCStaffID' => $user->userID,
                        'staffPosition' => 'Default Position' // Adjust as needed
                    ]);
                }
                break;

            case 'agency':
                if (!Agency::where('userID', $user->userID)->exists()) {
                    Agency::create([
                        'userID' => $user->userID,
                        'agencyID' => $user->userID,
                        'PIC' => 'Default PIC' // Adjust as needed
                    ]);
                }
                break;
        }

        // Redirect based on role
        return match ($user->userType) {
            'public' => redirect()->route('InquiryProgress.publicInquiryTracking'),
            'mcmc' => redirect()->route('Dashboard.mcmcDashboard'),
            'agency' => redirect()->route('Dashboard.agencyDashboard'),
        };
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}