<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    protected $fillable = [
        'train_number',
        'train_name',
        'train_name_bn',
        'train_type',
        'status',
    ];

    public function coaches()
    {
        return $this->hasMany(TrainCoach::class);
    }

    public function activeCoaches()
    {
        return $this->hasMany(TrainCoach::class)->where('status', 'active');
    }
}