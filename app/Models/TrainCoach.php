<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainCoach extends Model
{
    protected $fillable = [
        'train_id',
        'seat_class_id',
        'coach_number',
        'total_seats',
        'layout_json',
        'status',
    ];

    protected $casts = [
        'layout_json' => 'array',
    ];

    public function train()
    {
        return $this->belongsTo(Train::class);
    }

    public function seatClass()
    {
        return $this->belongsTo(SeatClass::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class, 'coach_id');
    }
}