<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderFood extends Model
{
    protected $fillable = ['order_id', 'kitchen_food_id', 'name', 'quantity', 'price', 'total'];

    public function food()
    {
        return $this->belongsTo('App\Model\KitchenFood', 'kitchen_food_id', 'id');
    }
}
