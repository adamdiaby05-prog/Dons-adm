<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'contribution_id',
        'payment_reference',
        'amount',
        'payment_method',
        'phone_number',
        'status',
        'gateway_response',
        'processed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
