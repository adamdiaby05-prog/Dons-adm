<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'currency',
        'payment_method',
        'phone_number',
        'network',
        'status',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
