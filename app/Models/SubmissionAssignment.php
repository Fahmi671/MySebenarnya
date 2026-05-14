<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionAssignment extends Model
{
    protected $table = 'SubmissionAssignment';
    protected $primaryKey = 'assignmentID';
    public $timestamps = false;

    protected $fillable = [
        'agencyID',
        'MCMCStaffID',
        'submissionID',
        'assignmentDate',
        'jurisdictionStatus',
        'comment',
    ];

    public function agency()
{
    return $this->belongsTo(Agency::class, 'agencyID', 'agencyID');
}

    public function inquirySubmission()
    {
        return $this->belongsTo(InquirySubmission::class, 'submissionID', 'submissionID');
    }
    
    public function progress()
    {
        return $this->hasOne(InquiryProgress::class, 'assignmentID', 'assignmentID');
    }
}