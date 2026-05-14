<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryProgress extends Model
{
    use HasFactory;
    protected $table = 'InquiryProgress';
    protected $primaryKey = 'ProgressID';
    public $timestamps = false;

    protected $fillable = [
        'ProgressID',
        'AssignmentID',
        'SubmissionID',
        'AgencyID',
        'JurisdictionStatus',
        'VerificationStatus',
        'VerificationDate',
        'InvestigationDetails',
    ];

    // Relationship to InquirySubmission
    public function inquiry()
    {
        return $this->belongsTo(InquirySubmission::class, 'submissionID', 'submissionID');
    }

    // Relationship to SubmissionAssignment
    public function assignment()
    {
        return $this->belongsTo(SubmissionAssignment::class, 'AssignmentID');
    }
}