<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'type',
        'capacity',
        'current_train',
        'next_arrival',
        'last_maintenance',
        'maintenance_notes',
    ];

    protected $casts = [
        'next_arrival' => 'datetime',
        'last_maintenance' => 'datetime',
    ];
}