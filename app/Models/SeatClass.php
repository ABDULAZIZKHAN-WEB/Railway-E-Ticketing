<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeatClass extends Model
{
    protected $fillable = [
        'class_code',
        'class_name',
        'class_name_bn',
        'base_price_per_km',
        'amenities_json',
    ];

    protected $casts = [
        'amenities_json' => 'array',
        'base_price_per_km' => 'decimal:2',
    ];

    public function getAmenitiesAttribute()
    {
        return $this->amenities_json ?? [];
    }
}