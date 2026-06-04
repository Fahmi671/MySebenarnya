<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SubmissionAssignment;
use App\Models\InquirySubmission;
use App\Models\Agency;

class AssignmentController extends Controller
{
    public function showAssignedAgency($submissionID)
    {
        // Get current logged-in user's publicUserID (if using Auth)
        $user = Auth::user();
        $publicUser = $user ? $user->publicUser : null;
        if (!$publicUser) {
            return redirect()->back()->withErrors('No public user found.');
        }

        // Check that the inquiry belongs to this user
        $inquiry = InquirySubmission::where('submissionID', $submissionID)
            ->where('publicUserID', $publicUser->publicUserID)
            ->firstOrFail();

        // Get all assignments for this inquiry, eager load agency
        $assignments = SubmissionAssignment::with('agency.user')
            ->where('submissionID', $submissionID)
            ->where('jurisdictionStatus', 'Accepted')
            ->get();

        return view('InquiryAssignment.publicAgencyAssignment', compact('assignments', 'inquiry'));
    }

    public function mcmcAssignInquiryPage()
    {
        // 1. Inquiries never assigned
        $neverAssigned = \App\Models\InquirySubmission::where('submissionStatus', 'Verified Inquiry')
            ->whereNotIn('submissionID', function($query) {
                $query->select('submissionID')->from('SubmissionAssignment');
            });

        // 2. Inquiries assigned, but all assignments are Rejected (need to be reassigned)
        $rejectedAssigned = \App\Models\InquirySubmission::where('submissionStatus', 'Verified Inquiry')
            ->whereIn('submissionID', function($query) {
                $query->select('submissionID')
                    ->from('SubmissionAssignment')
                    ->where('jurisdictionStatus', 'Rejected');
            })
            // Make sure ALL assignments for this inquiry are 'Rejected'
            ->whereNotIn('submissionID', function($query) {
                $query->select('submissionID')
                    ->from('SubmissionAssignment')
                    ->where('jurisdictionStatus', '!=', 'Rejected');
            });

        // Union and get all inquiries needing assignment
        $inquiries = $neverAssigned->union($rejectedAssigned)
            ->orderBy('submissionDate', 'desc')
            ->get();

        return view('InquiryAssignment.mcmcAssignInquiry', compact('inquiries'));
    }

    public function showAssignInquiryDetails($submissionID)
    {
        // Get inquiry
        $inquiry = InquirySubmission::findOrFail($submissionID);

        // Prefer agencies that have successfully handled this inquiry category before
        $category = $inquiry->submissionCategory;

        $categoryMap = [
            'crime' => 'Polis Diraja Malaysia',
            'health' => 'Kementerian Kesihatan Malaysia',
            'briber' => 'Suruhanjaya Pencegahan Jenayah',
        ];

        $preferredAgencyName = null;
        $lowerCategory = strtolower($category ?? '');
        foreach ($categoryMap as $keyword => $agencyName) {
            if (str_contains($lowerCategory, $keyword)) {
                $preferredAgencyName = $agencyName;
                break;
            }
        }

        $suggestedAgencyId = null;

        if ($preferredAgencyName) {
            $suggestedAgencyId = Agency::whereHas('user', function ($query) use ($preferredAgencyName) {
                $query->where('name', 'like', "%{$preferredAgencyName}%");
            })->value('agencyID');
        }

        if (!$suggestedAgencyId) {
            $suggestedAgencyId = SubmissionAssignment::select('agencyID', DB::raw('COUNT(*) as accepted_count'))
                ->where('jurisdictionStatus', 'Accepted')
                ->whereHas('inquirySubmission', function ($query) use ($category) {
                    $query->where('submissionCategory', $category);
                })
                ->groupBy('agencyID')
                ->orderByDesc('accepted_count')
                ->value('agencyID');
        }

        if (!$suggestedAgencyId) {
            $suggestedAgencyId = SubmissionAssignment::select('agencyID', DB::raw('COUNT(*) as accepted_count'))
                ->where('jurisdictionStatus', 'Accepted')
                ->groupBy('agencyID')
                ->orderByDesc('accepted_count')
                ->value('agencyID');
        }

        if ($suggestedAgencyId) {
            $suggestedAgencies = Agency::with('user')
                ->where('agencyID', $suggestedAgencyId)
                ->get();
        } else {
            $suggestedAgencies = collect();
        }

        // Get all agencies for dropdown
        $agencies = Agency::with('user')->get();

        return view('InquiryAssignment.mcmcAssignInquiryDetails', compact('inquiry', 'agencies', 'suggestedAgencies'));
    }

    public function storeAssignment(Request $request, $submissionID)
    {
        $request->validate([
            'agencyID' => 'required|exists:Agency,agencyID',
        ]);

        $staff = auth()->user()->mcmcStaff; // This will give you the MCMCStaff model for the logged-in user

        SubmissionAssignment::create([
            'agencyID'           => $request->agencyID,
            'MCMCStaffID'        => $staff->MCMCStaffID,  // Get the ID from the staff model
            'submissionID'       => $submissionID,
            'assignmentDate'     => now(),
            'jurisdictionStatus' => 'Pending', // or any value you want
            'comment'            => $request->comment,
        ]);

        return redirect()->route('InquiryAssignment.mcmcAssignInquiry')->with('success', 'Agency assigned successfully!');
    }

    public function agencyIncomingInquiry()
    {
        $agency = Auth::user()->agency;
        if (!$agency) {
            return redirect()->back()->withErrors('No agency found for this user.');
        }
        $assignments = SubmissionAssignment::with('inquirySubmission')
            ->where('agencyID', $agency->agencyID)
            ->where('jurisdictionStatus', 'Pending')
            ->orderBy('assignmentDate', 'desc')
            ->get();
        return view('InquiryAssignment.agencyIncomingInquiry', compact('assignments'));
    }

    public function agencyShowInquiry($assignmentID)
    {
        $agency = \Auth::user()->agency;
        if (!$agency) {
            return redirect()->back()->withErrors('No agency found for this user.');
        }
        $assignment = \App\Models\SubmissionAssignment::with('inquirySubmission')
            ->where('assignmentID', $assignmentID)
            ->where('agencyID', $agency->agencyID)
            ->firstOrFail();
        $inquiry = $assignment->inquirySubmission;
        return view('InquiryAssignment.agencyIncomingInquiryDetails', compact('assignment', 'inquiry'));
    }

    public function acceptInquiry(Request $request, $assignmentID)
    {
        $agency = \Auth::user()->agency;
        $assignment = \App\Models\SubmissionAssignment::where('assignmentID', $assignmentID)
            ->where('agencyID', $agency->agencyID)
            ->firstOrFail();
        $assignment->jurisdictionStatus = 'Accepted';
        $assignment->comment = $request->input('accept_comment', '');
        $assignment->save();
        return redirect()->route('InquiryAssignment.agencyIncomingInquiry')->with('success', 'Inquiry accepted. Proceed with verification.');
    }

    public function rejectInquiry(Request $request, $assignmentID)
    {
        $request->validate([
            'rejection_comment' => 'required|string|max:1000',
        ]);
        $agency = \Auth::user()->agency;
        $assignment = \App\Models\SubmissionAssignment::where('assignmentID', $assignmentID)
            ->where('agencyID', $agency->agencyID)
            ->firstOrFail();
        $assignment->jurisdictionStatus = 'Rejected';
        $assignment->comment = $request->rejection_comment;
        $assignment->save();
        return redirect()->route('InquiryAssignment.agencyIncomingInquiry')->with('success', 'Inquiry rejected and MCMC notified.');
    }
}