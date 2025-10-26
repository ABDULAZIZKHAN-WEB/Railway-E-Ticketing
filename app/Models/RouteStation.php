<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteStation extends Model
{
    protected $fillable = [
        'route_id',
        'station_id',
        'sequence_order',
        'arrival_time_offset_minutes',
        'departure_time_offset_minutes',
        'platform_number',
        'distance_from_start_km',
        'halt_duration_minutes',
    ];

    protected $casts = [
        'distance_from_start_km' => 'decimal:2',
        'arrival_time_offset_minutes' => 'integer',
        'departure_time_offset_minutes' => 'integer',
        'halt_duration_minutes' => 'integer',
    ];

    public function route()
    {
        return $this->belongsTo(Route::class);
    }

    public function station()
    {
        return $this->belongsTo(Station::class);
    }
}