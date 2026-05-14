<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InquirySubmission;
use App\Models\Agency;
use App\Models\InquiryProgress;
use App\Models\SubmissionAssignment;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ReportController extends Controller
{
    public function mcmcReportPage()
    {
        return view('GenerateReport.mcmcReportPage');
    }

    public function viewInquiryReport()
    {
        // Logic to fetch and process Inquiry Report data
        return view('GenerateReport.mcmcGenerateInquiryReport');
    }

    public function mcmcInquiryAssignmentReport(Request $request)
    {
        $agencyID = $request->agency_id;
        $start = $request->start_date;
        $end = $request->end_date;

        $query = SubmissionAssignment::with([
            'agency.user',        // Eager load agency and user
            'inquirySubmission'
        ])
            ->when($agencyID, fn($q) => $q->where('agencyID', $agencyID))
            ->when($start, fn($q) => $q->whereDate('assignmentDate', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('assignmentDate', '<=', $end));

        $assignmentsByAgency = (clone $query)
            ->selectRaw('agencyID, count(*) as total')
            ->groupBy('agencyID')
            ->with('agency.user')
            ->get();

        $assignments = $query->orderByDesc('assignmentDate')->get();

        $agencies = \App\Models\Agency::select('Agency.*')
            ->leftJoin('Users', 'Agency.userID', '=', 'Users.userID')
            ->with('user')
            ->orderBy('Users.name')
            ->get();

        return view('GenerateReport.mcmcInquiryAssignmentReport', compact(
            'assignments', 'assignmentsByAgency', 'agencies', 'agencyID', 'start', 'end'
        ));
    }

    public function exportAssignmentPdf(Request $request)
    {
        $agencyID = $request->agency_id;
        $start = $request->start_date;
        $end = $request->end_date;

        $query = SubmissionAssignment::with(['agency.user', 'inquirySubmission'])
            ->when($agencyID, fn($q) => $q->where('agencyID', $agencyID))
            ->when($start, fn($q) => $q->whereDate('assignmentDate', '>=', $start))
            ->when($end, fn($q) => $q->whereDate('assignmentDate', '<=', $end));

        $assignments = $query->orderByDesc('assignmentDate')->get();

        // Make sure you have the correct PDF view and it uses agency->user->name
        $pdf = Pdf::loadView('GenerateReport.mcmcAssignmentReportPdf', compact('assignments'));
        return $pdf->download('assignment_report.pdf');
    }

    public function exportAssignmentHtmlExcel()
    {
         $assignments = \App\Models\SubmissionAssignment::with(['agency.user', 'inquirySubmission'])
        ->orderByDesc('assignmentDate')
        ->get();

    $fileName = 'assignment_report.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
    ];

    $callback = function() use ($assignments) {
        $file = fopen('php://output', 'w');
        // CSV header
        fputcsv($file, ['Assignment ID', 'Agency', 'Inquiry Title', 'Date Assigned']);

        foreach ($assignments as $assignment) {
            fputcsv($file, [
                $assignment->assignmentID,
                $assignment->agency->user->name ?? '-',
                $assignment->inquirySubmission->submissionTitle ?? '-',
                \Carbon\Carbon::parse($assignment->assignmentDate)->format('Y-m-d'),
            ]);
        }
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
    }
    /**
     * Agency Performance Report
     *
     * For each agency (users with userType = 'agency' and username as key):
     * - assigned: count of inquiryprogress rows for the agency (via SubmissionAssignment agencyID)
     * - resolved: count of inquiryprogress with verificationStatus = 'Verified as True' or 'Identified as Fake'
     *             OR submissionassignment.jurisdictionStatus = 'Accepted'
     * - pending:  count of inquiryprogress with verificationStatus = 'Under Investigation'
     * - Filtering is supported for agency username, submissionCategory, and date range (submissionDate)
     */
    public function viewPerformanceReport(Request $request)
    {
        // Fetch only users with userType 'agency'
        $agencies = User::where('userType', 'agency')->get();

        // Fetch unique categories from InquirySubmission
        $categories = InquirySubmission::select('submissionCategory')
            ->distinct()
            ->pluck('submissionCategory');

        // Filters
        $selectedAgency = $request->input('agency_id');
        $selectedCategory = $request->input('submissionCategory');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $performanceData = [];

        foreach ($agencies as $agency) {
            // If filtering by agency, skip others
            if ($selectedAgency && $agency->username !== $selectedAgency) {
                continue;
            }

            // Find all assignments for this agency
            $assignmentsQuery = SubmissionAssignment::where('agencyID', $agency->userID);

            // Filter by category and date (joins with InquirySubmission)
            if ($selectedCategory || $startDate || $endDate) {
                $assignmentsQuery->whereHas('inquirySubmission', function ($q) use ($selectedCategory, $startDate, $endDate) {
                    if ($selectedCategory) {
                        $q->where('submissionCategory', $selectedCategory);
                    }
                    if ($startDate) {
                        $q->whereDate('submissionDate', '>=', $startDate);
                    }
                    if ($endDate) {
                        $q->whereDate('submissionDate', '<=', $endDate);
                    }
                });
            }
            $assignments = $assignmentsQuery->get();
            $assignmentIDs = $assignments->pluck('assignmentID');

            // Assigned: all inquiryprogress for this agency
            $assigned = InquiryProgress::whereIn('assignmentID', $assignmentIDs)->count();

            // Resolved: inquiryprogress with verificationStatus 'Verified as True' or 'Identified as Fake'
            $resolved = InquiryProgress::whereIn('assignmentID', $assignmentIDs)
                ->whereIn('verificationStatus', ['Verified as True', 'Identified as Fake'])
                ->count();

            // Add jurisdictionStatus = 'Accepted' (from assignments table)
            $resolved += $assignments->where('jurisdictionStatus', 'Accepted')->count();

            // Pending: inquiryprogress with verificationStatus 'Under Investigation'
            $pending = InquiryProgress::whereIn('assignmentID', $assignmentIDs)
                ->where('verificationStatus', 'Under Investigation')
                ->count();

            $performanceData[] = [
                'agency_name' => $agency->username,
                'assigned' => $assigned,
                'resolved' => $resolved,
                'pending' => $pending,
            ];
        }

        return view('GenerateReport.mcmcAgencyPerformanceReport', compact(
            'agencies',
            'categories',
            'performanceData'
        ));
    }

    public function generateInquiryReport(Request $request)
    {
        $query = InquirySubmission::whereIn('submissionStatus', ['Verified Inquiry', 'Dismissed Inquiry']); // Fetch only relevant inquiries

        // Apply filters dynamically
        if ($request->filled('category')) {
            $query->where('submissionStatus', $request->category);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('submissionDate', [$request->start_date, $request->end_date]);
        }

        $inquiries = $query->get(); // Retrieve inquiries

        return view('GenerateReport.mcmcGenerateInquiryReport', compact('inquiries')); // Pass data correctly
    }

    public function chartData()
    {
        // Fetch inquiry count by submission category
        $categoryData = InquirySubmission::selectRaw('submissionCategory, COUNT(*) as total')
            ->groupBy('submissionCategory')
            ->pluck('total', 'submissionCategory');

        // Fetch Verified vs. Dismissed Inquiry counts
        $verifiedCount = InquirySubmission::where('submissionStatus', 'Verified Inquiry')->count();
        $dismissedCount = InquirySubmission::where('submissionStatus', 'Dismissed Inquiry')->count();

        return response()->json([
            'categories' => $categoryData->keys(),
            'categoryCounts' => $categoryData->values(),
            'verifiedCount' => $verifiedCount,
            'dismissedCount' => $dismissedCount,
        ]);
    }

    // Generate Inquiry Report as PDF
    public function exportPDFInquiry(Request $request)
    {
        $inquiries = InquirySubmission::query();

        // Optional: Apply filters if passed
        if ($request->has('category')) {
            $inquiries->where('submissionStatus', $request->category);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $inquiries->whereBetween('submissionDate', [$request->start_date, $request->end_date]);
        }

        $data = $inquiries->get();

        $pdf = Pdf::loadView('GenerateReport.mcmcInquiryReportPdf', compact('data'));
        return $pdf->download('total_inquiry_report.pdf');
    }


    // Generate Report as Excel
    public function exportExcel()
    {
        $data = \App\Models\InquirySubmission::orderByDesc('submissionDate')->get();
        $fileName = 'inquiry_report.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            // Add the column headers
            fputcsv($file, ['Date', 'Title', 'Category', 'Status']);
            // Add the data rows
            foreach ($data as $inquiry) {
                fputcsv($file, [
                    $inquiry->submissionDate,
                    $inquiry->submissionTitle,
                    $inquiry->submissionCategory,
                    $inquiry->submissionStatus
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    
    public function exportPerformancePdf(Request $request)
    {
        // Fetch only users with userType 'agency'
        $agencies = User::where('userType', 'agency')->get();

        // Fetch unique categories from InquirySubmission
        $categories = InquirySubmission::select('submissionCategory')
            ->distinct()
            ->pluck('submissionCategory');

        // Filters
        $selectedAgency = $request->input('agency_id');
        $selectedCategory = $request->input('submissionCategory');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $performanceData = [];

        foreach ($agencies as $agency) {
            // If filtering by agency, skip others
            if ($selectedAgency && $agency->username !== $selectedAgency) {
                continue;
            }

            // Find all assignments for this agency
            $assignmentsQuery = SubmissionAssignment::where('agencyID', $agency->userID);

            // Filter by category and date (joins with InquirySubmission)
            if ($selectedCategory || $startDate || $endDate) {
                $assignmentsQuery->whereHas('inquirySubmission', function ($q) use ($selectedCategory, $startDate, $endDate) {
                    if ($selectedCategory) {
                        $q->where('submissionCategory', $selectedCategory);
                    }
                    if ($startDate) {
                        $q->whereDate('submissionDate', '>=', $startDate);
                    }
                    if ($endDate) {
                        $q->whereDate('submissionDate', '<=', $endDate);
                    }
                });
            }
            $assignments = $assignmentsQuery->get();
            $assignmentIDs = $assignments->pluck('assignmentID');

            // Assigned: all inquiryprogress for this agency
            $assigned = InquiryProgress::whereIn('assignmentID', $assignmentIDs)->count();

            // Resolved: inquiryprogress with verificationStatus 'Verified as True' or 'Identified as Fake'
            $resolved = InquiryProgress::whereIn('assignmentID', $assignmentIDs)
                ->whereIn('verificationStatus', ['Verified as True', 'Identified as Fake'])
                ->count();

            // Add jurisdictionStatus = 'Accepted' (from assignments table)
            $resolved += $assignments->where('jurisdictionStatus', 'Accepted')->count();

            // Pending: inquiryprogress with verificationStatus 'Under Investigation'
            $pending = InquiryProgress::whereIn('assignmentID', $assignmentIDs)
                ->where('verificationStatus', 'Under Investigation')
                ->count();

            $performanceData[] = [
                'agency_name' => $agency->username,
                'assigned' => $assigned,
                'resolved' => $resolved,
                'pending' => $pending,
            ];
        }

        // Generate PDF using your existing Blade view (adjust the view path as needed)
        $pdf = Pdf::loadView('GenerateReport.mcmcAgencyPerformanceReportPdf', [
            'agencies' => $agencies,
            'categories' => $categories,
            'performanceData' => $performanceData,
            'selectedAgency' => $selectedAgency,
            'selectedCategory' => $selectedCategory,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        return $pdf->download('Agency_Performance_Report.pdf');
    }

    public function exportPerformanceExcel(Request $request)
    {
        $agencies = User::where('userType', 'agency')->get();
        $categories = InquirySubmission::select('submissionCategory')->distinct()->pluck('submissionCategory');

        $selectedAgency = $request->input('agency_id');
        $selectedCategory = $request->input('submissionCategory');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $performanceData = [];
        foreach ($agencies as $agency) {
            if ($selectedAgency && $agency->username !== $selectedAgency) continue;

            $assignmentsQuery = SubmissionAssignment::where('agencyID', $agency->userID);
            if ($selectedCategory || $startDate || $endDate) {
                $assignmentsQuery->whereHas('inquirySubmission', function ($q) use ($selectedCategory, $startDate, $endDate) {
                    if ($selectedCategory) $q->where('submissionCategory', $selectedCategory);
                    if ($startDate) $q->whereDate('submissionDate', '>=', $startDate);
                    if ($endDate) $q->whereDate('submissionDate', '<=', $endDate);
                });
            }
            $assignments = $assignmentsQuery->get();
            $assignmentIDs = $assignments->pluck('assignmentID');

            $assigned = InquiryProgress::whereIn('assignmentID', $assignmentIDs)->count();
            $resolved = InquiryProgress::whereIn('assignmentID', $assignmentIDs)
                ->whereIn('verificationStatus', ['Verified as True', 'Identified as Fake'])->count();
            $resolved += $assignments->where('jurisdictionStatus', 'Accepted')->count();
            $pending = InquiryProgress::whereIn('assignmentID', $assignmentIDs)
                ->where('verificationStatus', 'Under Investigation')->count();

            $performanceData[] = [
                'Agency' => $agency->username,
                'Assigned' => $assigned,
                'Resolved' => $resolved,
                'Pending' => $pending,
            ];
        }

        // Prepare CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="Agency_Performance_Report.csv"',
        ];

        // Create callback to output CSV
        $callback = function() use ($performanceData) {
            $file = fopen('php://output', 'w');
            // Output headings
            fputcsv($file, ['Agency', 'Assigned', 'Resolved', 'Pending']);
            // Output data
            foreach ($performanceData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}