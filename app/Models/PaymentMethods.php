<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{

    protected $fillable = [
        'method_name', 'description', 'active', 'account_holder', 'amount_number', 'qr'
    ];

    protected $casts = [
        'active' => 'boolean',
        'method_name' => 'string',
        'description' => 'string',
        'account_holder' => 'string',
        'amount_number' => 'integer',
        'qr' => 'string',
    ];
}
