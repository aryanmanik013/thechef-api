<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScheduledFood extends Model
{
    use SoftDeletes;

    protected $fillable = ['kitchen_food_id', 'food_schedule_id', 'quantity', 'price', 'status'];

    public function KitchenFood()
    {
        return $this->belongsTo('App\Model\KitchenFood', 'kitchen_food_id', 'id');
    }
}
