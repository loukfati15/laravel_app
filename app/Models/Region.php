<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['region_name', 'region_number', 'country'];

    public function superusers()
    {
        return $this->belongsToMany(Superuser::class, 'region_superuser', 'region_id', 'superuser_id');
    }
}

