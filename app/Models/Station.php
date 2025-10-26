<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = [
        'station_code',
        'station_name',
        'station_name_bn',
        'division',
        'district',
        'latitude',
        'longitude',
        'facilities_json',
        'status',
    ];

    protected $casts = [
        'facilities_json' => 'array',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function getFacilitiesAttribute()
    {
        return $this->facilities_json ?? [];
    }
}