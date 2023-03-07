<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponCategory extends Model
{
    //
    protected $fillable = [
        'coupon_id', 'food_category_id',
    ];

    public function category()
    {
        return $this->belongsTo('App\Model\FoodCategory');
    }
}
