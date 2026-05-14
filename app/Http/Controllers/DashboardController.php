<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agency;
use App\Models\PublicUser;

class DashboardController extends Controller
{
    public function mcmcDashboard()
    {
        // Count total users
        $totalUsers = User::count();
        // Count public users (assuming userType = 'Public')
        $publicUserCount = User::where('userType', 'Public')->count();
        // Count agencies (distinct user IDs in Agency table)
        $agencyCount = Agency::count();

        return view('Dashboard.mcmcDashboard', compact('totalUsers', 'publicUserCount', 'agencyCount'));
    }

    public function agencyDashboard()
    {
         // Get authenticated agency user
        $agency = auth()->user()->agency;

        // Count the total assigned inquiries with jurisdictionStatus 'Accepted'
        $acceptedCount = 0;
        if ($agency) {
            $acceptedCount = $agency->assignments()->where('jurisdictionStatus', 'Accepted')->count();
        }

        return view('Dashboard.agencyDashboard', compact('acceptedCount'));
    }
}