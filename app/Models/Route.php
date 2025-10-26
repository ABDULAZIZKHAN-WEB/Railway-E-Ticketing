<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    protected $fillable = [
        'route_name',
        'start_station_id',
        'end_station_id',
        'total_distance_km',
        'estimated_duration_minutes',
        'status',
    ];

    protected $casts = [
        'total_distance_km' => 'decimal:2',
        'estimated_duration_minutes' => 'integer',
    ];

    public function startStation()
    {
        return $this->belongsTo(Station::class, 'start_station_id');
    }

    public function endStation()
    {
        return $this->belongsTo(Station::class, 'end_station_id');
    }

    public function routeStations()
    {
        return $this->hasMany(RouteStation::class);
    }
}