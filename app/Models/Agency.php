<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    use HasFactory;

    protected $table = 'Agency';
    protected $primaryKey = 'agencyID';
    public $timestamps = false;

    protected $fillable = [
        'userID',
        'agencyID',
        'PIC'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID', 'userID');
    }
    public function assignments()
    {
        return $this->hasMany(SubmissionAssignment::class, 'agencyID');
    }

    public function progress()
    {
        return $this->hasMany(InquiryProgress::class, 'agencyID');
    }
}