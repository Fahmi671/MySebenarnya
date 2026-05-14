<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicUser extends Model
{
    use HasFactory;

    protected $table = 'PublicUser';
    protected $primaryKey = 'publicUserID';
    public $timestamps = false;

    protected $fillable = [
        'userID',
        'publicUserID',
        'publicUserAge'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function inquiries()
    {
        return $this->hasMany(InquirySubmission::class, 'publicUserID');
    }

    public function inquirySubmissions()
    {
        return $this->hasMany(InquirySubmission::class, 'publicUserID', 'publicUserID');
    }
}