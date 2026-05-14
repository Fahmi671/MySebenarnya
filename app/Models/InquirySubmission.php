<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquirySubmission extends Model
{
    use HasFactory;

    protected $table = 'InquirySubmission';
    protected $primaryKey = 'submissionID';
    public $timestamps = false;

    protected $fillable = [
        'publicUserID',
        'submissionTitle',
        'submissionDescription',
        'submissionCategory',
        'submissionEvidence',
        'sourceOfNews',
        'submissionDate',
        'submissionStatus',
    ];

    public function publicUser()
    {
        return $this->belongsTo(PublicUser::class, 'publicUserID');
    }

    public function progress()
    {
        return $this->hasOne(InquiryProgress::class, 'submissionID');
    }

    public function assignments()
    {
        return $this->hasMany(SubmissionAssignment::class, 'submissionID');
    }

    public function scopeFilterByCategory($query, $category)
    {
        return $query->where('submissionCategory', $category);
    }

    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('submissionDate', [$startDate, $endDate]);
    }

    public function scopeMonthly($query, $month, $year)
    {
        return $query->whereYear('submissionDate', $year)
            ->whereMonth('submissionDate', $month);
    }

    public function scopeYearly($query, $year)
    {
        return $query->whereYear('submissionDate', $year);
    }
    public function latestAssignment()
    {
        
        return $this->hasOne(\App\Models\SubmissionAssignment::class, 'submissionID', 'submissionID')
            ->latest('assignmentDate');
    }
}