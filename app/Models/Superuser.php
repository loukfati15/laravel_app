<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Superuser extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'approved', 'N_telephone', 'poste', 'user_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function regions()
    {
        return $this->belongsToMany(Region::class, 'region_superuser', 'superuser_id', 'region_id');
    }
}

