<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_reference',
        'user_id',
        'train_schedule_id',
        'journey_date',
        'from_station_id',
        'to_station_id',
        'total_passengers',
        'total_amount',
        'booking_status',
        'payment_status',
        'booked_by_role',
        'booked_by_user_id',
    ];

    protected $casts = [
        'journey_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainSchedule()
    {
        return $this->belongsTo(TrainSchedule::class);
    }

    public function fromStation()
    {
        return $this->belongsTo(Station::class, 'from_station_id');
    }

    public function toStation()
    {
        return $this->belongsTo(Station::class, 'to_station_id');
    }

    public function bookingPassengers()
    {
        return $this->hasMany(BookingPassenger::class);
    }

    public function bookedBy()
    {
        return $this->belongsTo(User::class, 'booked_by_user_id');
    }
}