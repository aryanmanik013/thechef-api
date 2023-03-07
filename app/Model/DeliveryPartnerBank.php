<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

class DeliveryPartnerBank extends Model
{
    use SoftDeletes;
    use Mediable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'delivery_partner_id', 'bank_name', 'branch', 'payment_method', 'account_number', 'ifsc', 'swift', 'email', 'type', 'status',
    ];

}
