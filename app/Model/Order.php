<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'invoice_no', 'invoice_prefix', 'kitchen_id', 'kitchen_name', 'customer_id', 'name', 'email', 'phone',
        'payment_name', 'payment_phone', 'payment_address_1', 'payment_address_2', 'payment_city',
        'payment_locality', 'payment_landmark', 'payment_postcode', 'payment_country', 'payment_country_id',
        'payment_state', 'payment_state_id', 'payment_method', 'payment_code', 'payment_address_type',
        'payment_additional_phone', 'shipping_name', 'shipping_phone', 'shipping_address_1', 'shipping_address_2',
        'shipping_city', 'shipping_locality', 'shipping_landmark', 'shipping_postcode', 'shipping_country',
        'shipping_latitude', 'shipping_longitude', 'shipping_country_id', 'shipping_state', 'shipping_state_id',
        'shipping_method', 'shipping_code', 'shipping_address_type', 'shipping_additional_phone', 'alternate_product', 'dispute_status', 'comment', 'total',
        'order_total', 'coupon_discount', 'order_status_id', 'delivery_charge', 'delivery_partner_id', 'delivery_request_id', 'delivery_type', 'delivery_status_id'];

    public function deliveryPartner()
    {
        return $this->belongsTo('App\Model\DeliveryPartner', 'delivery_partner_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo('App\Model\State', 'shipping_state_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('App\Model\Country', 'shipping_country_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Model\OrderStatus', 'order_status_id', 'id');
    }
    public function deliveryStatus()
    {
        return $this->belongsTo('App\Model\DeliveryStatus', 'delivery_status_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Model\Customer', 'customer_id', 'id');
    }

    public function food()
    {
        return $this->hasMany('App\Model\OrderFood', 'order_id', 'id');
    }

    public function histories()
    {
        return $this->hasMany('App\Model\OrderHistory', 'order_id', 'id');
    }
    public function deliveryHistories()
    {
        return $this->hasMany('App\Model\OrderDeliveryHistory', 'order_id', 'id');
    }

    public function totals()
    {
        return $this->hasMany('App\Model\OrderTotal', 'order_id', 'id');
    }

    public function coupon()
    {
        return $this->hasOne('App\Model\CouponHistory', 'order_id', 'id');
    }

    /*
    public function cancel()
    {
    return $this->hasOne('App\Model\OrderCancellation','order_id','id');
    }*/

    public function reviews()
    {
        return $this->hasOne('App\Model\Review', 'order_id', 'id');
    }
    public function kitchen()
    {
        return $this->belongsTo('App\Model\Kitchen', 'kitchen_id', 'id');
    }
    public function payment()
    {
        return $this->hasMany('App\Model\OrderPayment', 'order_id', 'id');
    }
    public function orderHistory()
    {
        return $this->hasMany('App\Model\OrderHistory', 'order_id', 'id');
    }

}
