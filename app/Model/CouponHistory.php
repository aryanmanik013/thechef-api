<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponHistory extends Model
{
    protected $fillable = ['coupon_id', 'order_id', 'customer_id', 'amount'];

    public function order()
    {
        return $this->belongsTo('App\Model\Order', 'order_id', 'id');
    }

    public function coupon()
    {
        return $this->belongsTo('App\Model\Coupon', 'coupon_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo('App\Model\Customer', 'customer_id', 'id');
    }
}
