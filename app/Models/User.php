<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'Users';
    protected $primaryKey = 'userID';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'email',
        'contact',
        'password',
        'name',
        'userType'
    ];

    protected $hidden = [
        'password'
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Define relationships based on user roles
    public function publicUser()
    {
        return $this->hasOne(PublicUser::class, 'userID');
    }

    public function mcmcStaff()
    {
        return $this->hasOne(MCMCStaff::class, 'userID');
    }

    public function agency()
    {
        return $this->hasOne(Agency::class, 'userID');
    }
}