<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MCMCStaff extends Model
{
    use HasFactory;

    protected $table = 'MCMCStaff';
    protected $primaryKey = 'MCMCStaffID';
    public $timestamps = false;

    protected $fillable = [
        'userID',
        'MCMCStaffID',
        'staffPosition'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userID');
    }

    public function submissions()
    {
        return $this->hasMany(SubmissionAssignment::class, 'MCMCStaffID');
    }
}