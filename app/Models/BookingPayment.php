<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPayment extends Model
{
    protected $casts = [
        'pay_date'=> 'datetime',
    ];
}
