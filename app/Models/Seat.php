<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    protected $fillable = [
        'coach_id',
        'seat_number',
        'seat_type',
        'deck',
        'status',
    ];

    public function coach()
    {
        return $this->belongsTo(TrainCoach::class, 'coach_id');
    }

    public function bookingPassengers()
    {
        return $this->hasMany(BookingPassenger::class);
    }
}