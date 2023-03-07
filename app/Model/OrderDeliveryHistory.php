<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderDeliveryHistory extends Model
{

    protected $fillable = ['order_id', 'delivery_status_id', 'comment'];

    public function status()
    {
        return $this->belongsTo('App\Model\DeliveryStatus', 'delivery_status_id', 'id');
    }
}
