<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerTransactionDetails extends Model
{
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "pet_point",
        "uuid",
        'transaction_data',
    ];

    protected $casts = [
        'transaction_data' => 'array',
    ];
}
