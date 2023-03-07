<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AssignedDelivery extends Model
{
    protected $fillable = ['order_temp_id', 'delivery_partner_id', 'kitchen_id', 'address_id', 'accept_status', 'accepted_date', 'order_id', 'active_status', 'pickup_time'];

    public function kitchen()
    {
        return $this->belongsTo('App\Model\Kitchen', 'kitchen_id', 'id');
    }

    public function customerAddress()
    {
        return $this->belongsTo('App\Model\CustomerAddress', 'address_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo('App\Model\Order', 'order_id', 'id');
    }
}
