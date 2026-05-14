<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InquirySubmission;
use App\Models\SubmissionAssignment;
use Illuminate\Support\Facades\Storage;
use App\Models\InquiryProgress;

class ProgressController extends Controller
{
    public function publicInquiryTracking(Request $request)
    {
        $query = \App\Models\InquirySubmission::where('publicUserID', auth()->id());
    
        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('submissionTitle', 'like', "%{$search}%")
                  ->orWhere('submissionDescription', 'like', "%{$search}%");
            });
        }
    
        // Filter by status (applies to all status fields, see Blade for logic)
        if ($request->filled('status')) {
            $query->where(function ($q) use ($request) {
                $q->whereHas('progress', function ($q2) use ($request) {
                    $q2->where('verificationStatus', $request->status);
                })
                ->orWhereHas('latestAssignment', function ($q2) use ($request) {
                    $q2->where('jurisdictionStatus', $request->status);
                })
                ->orWhere('submissionStatus', $request->status);
            });
        }
    
        $inquiries = $query
            ->with(['progress', 'latestAssignment']) // eager load relationships
            ->orderBy('submissionDate', 'desc')
            ->paginate(10);
    
        return view('InquiryProgress.publicInquiryTracking', compact('inquiries'));
    }

    // Add this method for the details page
    public function mcmcMonitorAgencyProgress($submissionID)
    {
        // Eager load all assignments and progress for the inquiry submission
        $inquiry = InquirySubmission::with([
            'assignments.agency.user', // include agency.user for username
            'assignments.progress',
            'publicUser',
        ])->findOrFail($submissionID);

        return view('InquiryProgress.mcmcMonitorAgencyProgress', compact('inquiry'));
    }
    
    public function agencyAssignedInquiry(Request $request)
{
    $agencyId = auth()->user()->agency->agencyID ?? null;

    $inquiries = \App\Models\InquirySubmission::whereHas('assignments', function ($q) use ($agencyId) {
            $q->where('agencyID', $agencyId)
              ->where('jurisdictionStatus', 'Accepted')
              ->whereDoesntHave('progress'); // <-- Exclude those with progress
        })
        ->with(['assignments' => function ($q) use ($agencyId) {
            $q->where('agencyID', $agencyId)
              ->where('jurisdictionStatus', 'Accepted')
              ->whereDoesntHave('progress'); // <-- Exclude those with progress
        }])
        ->orderBy('submissionDate', 'desc')
        ->paginate(10);

    return view('InquiryProgress.agencyAssignedInquiry', compact('inquiries'));
}
public function agencyAssignedInquiryDetails($assignmentID)
{
    // Load assignment with related data
    $assignment = SubmissionAssignment::with([
        'inquirySubmission', // your relationship might be 'inquiry' or 'inquirySubmission'
        'progress'
    ])->findOrFail($assignmentID);

    return view('InquiryProgress.agencyAssignedInquiryDetails', compact('assignment'));
}

public function updateInvestigationStatus(Request $request, $assignmentID)
{
    $request->validate([
        'verificationStatus' => 'required|in:Verified as True,Identified as Fake',
        'investigationDetails' => 'nullable|string',
        'SupportingDocuments' => 'nullable|file|max:10240', // 10MB max, adjust as needed
    ]);

    $assignment = SubmissionAssignment::findOrFail($assignmentID);

    // Find or create InquiryProgress for this assignment
    $progress = InquiryProgress::where('assignmentID', $assignmentID)->first();
    if (!$progress) {
        $progress = new InquiryProgress();
        $progress->assignmentID = $assignmentID;
        $progress->submissionID = $assignment->submissionID;
        $progress->agencyID = $assignment->agencyID;
    }

    $progress->verificationStatus = $request->verificationStatus;
    $progress->verificationDate = now();
    $progress->investigationDetails = $request->investigationDetails;

    // Handle file upload (optional)
    if ($request->hasFile('SupportingDocuments')) {
        $file = $request->file('SupportingDocuments');
        $filename = uniqid('support_') . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('supporting_documents', $filename, 'public');
        $progress->SupportingDocuments = $path; // Save the path, not file content
    }

    $progress->save();

    return redirect()
    ->route('InquiryProgress.agencyAssignedInquiry')
    ->with('success', 'Status updated successfully.');
}
public function publicHistory(Request $request)
{
    $query = \App\Models\InquirySubmission::where('publicUserID', auth()->id());

    $inquiries = $query
        ->with(['progress', 'latestAssignment'])
        ->orderBy('submissionDate', 'desc')
        ->paginate(10);

    return view('InquiryProgress.publicHistory', compact('inquiries'));
}

public function publicHistoryDetails($submissionID)
{
    $inquiry = \App\Models\InquirySubmission::with([
        'assignments.agency.user',
        'assignments.progress'
    ])->findOrFail($submissionID);

    return view('InquiryProgress.publicHistoryDetails', compact('inquiry'));
}
}