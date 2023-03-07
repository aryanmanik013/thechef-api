<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KitchenFoodCategory extends Model
{

    protected $fillable = ['kitchen_food_id', 'food_category_id'];

    public function category()
    {
        return $this->belongsTo('App\Model\FoodCategory', 'food_category_id', 'id');
    }

}
