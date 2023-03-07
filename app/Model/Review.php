<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = ['kitchen_id', 'customer_id', 'order_id', 'heading', 'description', 'rating', 'status'];

    public function customer()
    {

        return $this->belongsTo('App\Model\Customer', 'customer_id', 'id');

    }
    public function Kitchen()
    {

        return $this->belongsTo('App\Model\Kitchen', 'kitchen_id', 'id');
    }
    public function order()
    {

        return $this->belongsTo('App\Model\Order', 'order_id', 'id');
    }
}
