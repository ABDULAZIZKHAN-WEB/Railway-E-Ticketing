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
        'total_coaches',
        'status',
    ];
}