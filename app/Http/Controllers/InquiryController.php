<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InquirySubmission;
use App\Models\SubmissionAssignment;
use App\Models\InquiryProgress;
use Illuminate\Support\Facades\Auth;

class InquiryController extends Controller
{
    // Public User - Create Inquiry Form (Module 2)
    public function createInquiry()
    {
        return view('InquirySubmission.publicAddInquiry');
    }

    // Public User - Store Inquiry Submission (Module 2)
    public function storeInquiry(Request $request)
    {
        $validated = $request->validate([
            'SubmissionTitle' => 'required|string|max:255',
            'SubmissionDescription' => 'required|string',
            'SubmissionCategory' => 'required|string',
            'SubmissionEvidence' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx',
            'SourceofNews' => 'nullable|url',
        ]);

        $filePath = null;
        if ($request->hasFile('SubmissionEvidence')) {
            $filePath = $request->file('SubmissionEvidence')->store('evidences', 'public');
        }

        InquirySubmission::create([
            'publicUserID' => Auth::id(),
            'submissionTitle' => $validated['SubmissionTitle'],
            'submissionDescription' => $validated['SubmissionDescription'],
            'submissionCategory' => $validated['SubmissionCategory'],
            'submissionEvidence' => $filePath,
            'sourceOfNews' => $validated['SourceofNews'],
            'submissionDate' => now(),
            'submissionStatus' => 'Pending Review',
        ]);

        return redirect()->route('InquirySubmission.publicAddInquiry')->with('success', 'Inquiry submitted successfully!');
    }

    // Public User - View Inquiry List (Module 2)
    public function list()
    {
        $inquiries = InquirySubmission::where('publicUserID', Auth::id())
            ->orderBy('submissionDate', 'desc')
            ->get();

        return view('InquirySubmission.publicViewInquiry', compact('inquiries'));
    }

    // Public User - View Inquiry Details (Module 2)
    public function showInquiryDetail($id)
    {
        $inquiry = InquirySubmission::where('submissionID', $id)
            ->where('publicUserID', Auth::id())
            ->firstOrFail();

        return view('InquirySubmission.publicViewInquiryDetails', compact('inquiry'));
    }

    // Public User - View Public Inquiries (Module 2)
    public function viewPublicInquiries()
    {
        $userID = Auth::id();

        $inquiries = InquirySubmission::where('publicUserID', '!=', $userID)
            ->orderBy('submissionDate', 'desc')
            ->get();

        return view('InquirySubmission.publicPublicInquiry', compact('inquiries'));
    }

    // MCMC Staff - View New Inquiries (Pending Review) (Module 2)
    public function mcmcNewInquiries()
    {
        $inquiries = InquirySubmission::where('submissionStatus', 'Pending Review')
            ->join('Users', 'InquirySubmission.publicUserID', '=', 'Users.userID')
            ->select(
                'InquirySubmission.*',
                'Users.name as submitter_name',
                'Users.email as submitter_email'
            )
            ->orderBy('submissionDate', 'desc')
            ->get();

        return view('InquirySubmission.mcmcNewInquiry', compact('inquiries'));
    }

    // MCMC Staff - View Inquiry Details (Module 2)
    public function mcmcInquiryDetails($id)
    {
        $inquiry = InquirySubmission::where('submissionID', $id)->firstOrFail();
        return view('InquirySubmission.mcmcNewInquiryDetails', compact('inquiry'));
    }

    //  MCMC Staff - Update Inquiry Status (Verified or Dismissed) (Module 2)
    public function updateInquiryStatus(Request $request, $id)
    {
        $inquiry = InquirySubmission::findOrFail($id); // Ensure inquiry exists
        $newStatus = $request->input('status');

        if ($newStatus === 'dismissed') {
            $inquiry->submissionStatus = 'Dismissed Inquiry';
        } elseif ($newStatus === 'verified') {
            $inquiry->submissionStatus = 'Verified Inquiry';
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid status']);
        }

        $inquiry->save();

        return response()->json(['success' => true]);
    }

    //  MCMC Staff - View Previously Filtered Inquiries (Verified / Dismissed) (Module 2)
    public function mcmcPreviousInquiries(Request $request)
    {
        // Fetch all previously reviewed inquiries
        $query = InquirySubmission::whereIn('submissionStatus', ['Verified Inquiry', 'Dismissed Inquiry']);

        // Apply filters based on request parameters
        if ($request->filled('date')) {
            $query->whereDate('submissionDate', $request->date);
        }
        if ($request->filled('status')) {
            $query->where('submissionStatus', $request->status);
        }
        if ($request->filled('agency')) {
            $query->where('agencyID', 'LIKE', '%' . $request->agency . '%');
        }

        $inquiries = $query->orderBy('submissionDate', 'desc')->get();

        return view('InquirySubmission.mcmcPreviousInquiry', compact('inquiries'));
    }

    // Agency View Inquiries Page
    public function agencyViewInquiries()
    {
        return view('agency_viewInquiries');
    }
    // Agency - View and Filter Previous Inquiries
    public function agencyPreviousInquiry(Request $request)
    {
        $agencyID = Auth::id();

        // Start query
        $query = InquiryProgress::join('SubmissionAssignment', 'InquiryProgress.submissionID', '=', 'SubmissionAssignment.submissionID')
            ->join('InquirySubmission', 'InquiryProgress.submissionID', '=', 'InquirySubmission.submissionID')
            ->where('SubmissionAssignment.agencyID', $agencyID)
            ->select(
                'InquirySubmission.submissionID',
                'SubmissionAssignment.assignmentID',
                'InquirySubmission.submissionTitle',
                'InquiryProgress.verificationStatus',
                'InquiryProgress.verificationDate',
                'SubmissionAssignment.assignmentDate'
            );

        // Apply filters
        if ($request->filled('investigationStatus')) {
            $query->where('InquiryProgress.verificationStatus', $request->investigationStatus);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('SubmissionAssignment.assignmentDate', [$request->start_date, $request->end_date]);
        }

        $inquiries = $query->orderBy('SubmissionAssignment.assignmentDate', 'desc')->get();

        return view('InquirySubmission.agencyPreviousInquiry', compact('inquiries'));
    }


    public function viewAgencyPreviousInquiryDetails($id)
    {
        // Get inquiry details
        $inquiry = InquirySubmission::where('submissionID', $id)->firstOrFail();

        // Get history records for this inquiry
        $history = InquiryProgress::where('submissionID', $id)
            ->orderBy('verificationDate', 'desc')
            ->get();

        return view('InquirySubmission.agencyPreviousInquiryDetails', compact('inquiry', 'history'));
    }
}