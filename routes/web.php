<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

// =======================
// Authentication Routes
// =======================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// =======================
// PUBLIC USER ROUTES
// =======================
Route::middleware(['auth'])->group(function () {
    Route::get('/publicuser/inquiry/tracking', [ProgressController::class, 'publicInquiryTracking'])
        ->name('InquiryProgress.publicInquiryTracking');

    Route::get('/publicuser/inquiry/add', [InquiryController::class, 'createInquiry'])->name('InquirySubmission.publicAddInquiry');
    Route::post('/publicuser/inquiry/store', [InquiryController::class, 'storeInquiry'])->name('InquirySubmission.inquiry.store');

    Route::get('/publicuser/inquiry/list', [InquiryController::class, 'list'])->name('InquirySubmission.publicViewInquiry');
    Route::get('/publicuser/inquiry/detail/{id}', [InquiryController::class, 'showInquiryDetail'])->name('InquirySubmission.publicViewInquiryDetails');

    Route::get('/publicuser/inquiry/assignment/{submissionID}', [AssignmentController::class, 'showAssignedAgency'])->name('InquiryAssignment.publicAgencyAssignment');

    Route::get('/publicuser/inquiry/public', [InquiryController::class, 'viewPublicInquiries'])->name('InquirySubmission.publicPublicInquiry');

    Route::get('/publicuser/notification', function () {
        return view('InquiryProgress.publicNotification');
    })->name('InquiryProgress.publicNotification');

    Route::get('/public/history', [\App\Http\Controllers\ProgressController::class, 'publicHistory'])
    ->name('InquiryProgress.publicHistory');
    Route::get('/public/history/{submissionID}', [\App\Http\Controllers\ProgressController::class, 'publicHistoryDetails'])
    ->name('InquiryProgress.publicHistoryDetails');
});

// =======================
// MCMC STAFF ROUTES
// =======================
Route::middleware(['auth'])->group(function () {
    Route::get('/mcmc/home', [DashboardController::class, 'mcmcDashboard'])->name('Dashboard.mcmcDashboard');

    // Inquiry Handling
    Route::get('/mcmc/inquiry/new', [InquiryController::class, 'mcmcNewInquiries'])->name('InquirySubmission.mcmcNewInquiry');
    Route::get('/mcmc/inquiry/detail/{id}', [InquiryController::class, 'mcmcInquiryDetails'])->name('InquirySubmission.mcmcInquiryDetails');
    Route::post('/mcmc/inquiry/update-status/{id}', [InquiryController::class, 'updateInquiryStatus'])->name('InquirySubmission.updateInquiryStatus');
    Route::get('/mcmc/inquiry/previous', [InquiryController::class, 'mcmcPreviousInquiries'])->name('InquirySubmission.mcmcPreviousInquiry');

    // Inquiry Assignment
    Route::get('/mcmc/inquiry/assign', [AssignmentController::class, 'mcmcAssignInquiryPage'])->name('InquiryAssignment.mcmcAssignInquiry');
    Route::get('/mcmc/inquiry/assign/details/{submissionID}', [AssignmentController::class, 'showAssignInquiryDetails'])->name('InquirySubmission.mcmcAssignInquiryDetails');
    Route::post('/mcmc/inquiry/assign/details/{submissionID}', [AssignmentController::class, 'storeAssignment'])->name('InquiryAssignment.storeAssignment');

    // Generate Report
    Route::get('/mcmc/report', [ReportController::class, 'mcmcReportPage'])->name('GenerateReport.mcmcReportPage');
    Route::get('/mcmc/report/assignment', [ReportController::class, 'viewAssignmentReport'])->name('GenerateReport.mcmcInquiryAssignmentReport');
    Route::get('/mcmc/report/performance', [ReportController::class, 'viewPerformanceReport'])->name('GenerateReport.mcmcAgencyPerformanceReport');
    
    // Generate Inquiry Report (Filtered)
    Route::get('/mcmc/report/inquiry', [ReportController::class, 'generateInquiryReport'])->name('GenerateReport.mcmcGenerateInquiryReport');
    Route::get('/mcmc/report/inquiry/filter', [ReportController::class, 'filterInquiryReport'])->name('GenerateReport.filterInquiryReport');

    // Export Reports
    Route::get('/mcmc/report/export/pdf', [ReportController::class, 'exportPDFInquiry'])->name('GenerateReport.exportPDFInquiry');
    Route::get('/mcmc/report/export/excel', [ReportController::class, 'exportExcel'])->name('GenerateReport.exportExcel');

    //Module 3 
    Route::get('/mcmc/inquiry-assignment-report', [ReportController::class, 'mcmcInquiryAssignmentReport'])->name('GenerateReport.mcmcInquiryAssignmentReport');
    Route::get('/mcmc/inquiry-assignment-report-pdf', [ReportController::class, 'exportAssignmentPdf'])->name('GenerateReport.mcmcAssignmentReportPdf');
    Route::get('/mcmc/inquiry-assignment-report-excel', [ReportController::class, 'exportAssignmentHtmlExcel'])->name('GenerateReport.mcmcInquiryAssignmentReportExcel');
    
    // Graphical Inquiry Analysis
    Route::get('/mcmc/report/charts', [ReportController::class, 'chartData'])->name('GenerateReport.chartData');

    // Monitor agency progress for specific inquiry
    Route::get(
        '/mcmc/monitor-agency-progress/{submissionID}',
        [ProgressController::class, 'mcmcMonitorAgencyProgress']
    )->name('InquiryProgress.mcmcMonitorAgencyProgress');
    Route::get('/agency-performance-report', [ReportController::class, 'viewPerformanceReport'])->name('ReportController.viewPerformanceReport');
    Route::get('/performance-report/export-pdf', [ReportController::class, 'exportPerformancePdf'])->name('ReportController.exportPerformancePdf');
    Route::get('/performance-report/export-excel', [ReportController::class, 'exportPerformanceExcel'])
    ->name('ReportController.exportPerformanceExcel');
});


// =======================
// AGENCY ROUTES
// =======================
Route::middleware(['auth'])->group(function () {
    Route::get('/agency/home', [DashboardController::class, 'agencyDashboard'])->name('Dashboard.agencyDashboard');

    //Previous inquiries
    Route::get('/agency/inquiry/list', [InquiryController::class, 'agencyPreviousInquiry'])->name('InquirySubmission.agencyPreviousInquiry');

    //Incoming inquiries
    Route::get('/agency/inquiry/incoming', [AssignmentController::class, 'agencyIncomingInquiry'])->name('InquiryAssignment.agencyIncomingInquiry');
    Route::get('/agency/inquiry/incoming/{assignmentID}', [AssignmentController::class, 'agencyShowInquiry'])->name('InquiryAssignment.agencyIncomingInquiryDetails');
    Route::post('/agency/inquiry/incoming/{assignmentID}/reject', [AssignmentController::class, 'rejectInquiry'])->name('InquiryAssignment.agencyRejectInquiry');
    Route::post('/agency/inquiry/incoming/{assignmentID}/accept', [AssignmentController::class, 'acceptInquiry'])->name('InquiryAssignment.agencyAcceptInquiry');

    //Assigned inquiries
    Route::get('/agency/inquiry/assigned', [ProgressController::class, 'agencyAssignedInquiry'])
        ->name('InquiryProgress.agencyAssignedInquiry');
    // Show details page
    Route::get('/agency-assigned-inquiry-details/{assignmentID}', [ProgressController::class, 'agencyAssignedInquiryDetails'])->name('InquiryProgress.agencyAssignedInquiryDetails');
    // Handle status update
    Route::post('/agency-assigned-inquiry-details/{assignmentID}/update-status', [ProgressController::class, 'updateInvestigationStatus'])->name('InquiryProgress.updateInvestigationStatus');

    Route::get('/agency/inquiry/list', [InquiryController::class, 'agencyPreviousInquiry'])->name('InquirySubmission.agencyPreviousInquiry');
    Route::get('/agency/inquiry/details/{id}', [InquiryController::class, 'viewAgencyPreviousInquiryDetails'])
        ->name('InquirySubmission.agencyPreviousInquiryDetails');
});