<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = ['order_id', 'order_status_id', 'notify_sms', 'notify_email', 'notify_push', 'comment'];

    public function status()
    {
        return $this->belongsTo('App\Model\OrderStatus', 'order_status_id', 'id');
    }
}
