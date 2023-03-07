<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = ['order_id', 'reference_id', 'payment_mode', 'currency', 'amount', 'payment_status', 'payment_signature', 'payment_time', 'status'];
}
