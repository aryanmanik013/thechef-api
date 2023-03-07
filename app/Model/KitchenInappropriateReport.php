<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KitchenInappropriateReport extends Model
{
    use SoftDeletes;

    protected $fillable = ['kitchen_id', 'customer_id', 'order_id', 'type', 'customer_name', 'remarks', 'reason_id', 'reason'];

    public function kitchen()
    {
        return $this->belongsTo('App\Model\Kitchen', 'kitchen_id', 'id');
    }
    public function order()
    {
        return $this->belongsTo('App\Model\Order', 'order_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo('App\Model\Customer', 'customer_id', 'id');
    }

}
