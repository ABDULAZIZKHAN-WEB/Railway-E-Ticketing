<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainSchedule extends Model
{
    protected $fillable = [
        'train_id',
        'route_id',
        'departure_time',
        'arrival_time',
        'running_days_json',
        'effective_from',
        'effective_to',
        'status',
        'delay_minutes',
        'reason',
        'details',
    ];

    protected $casts = [
        'running_days_json' => 'array',
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'effective_from' => 'date',
        'effective_to' => 'date',
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}