<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'rate',
        'start_date',
        'end_date',
        'client_pin',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'rate' => 'float',
        'amount' => 'float',
    ];
}
