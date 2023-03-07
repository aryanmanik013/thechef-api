<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class Coupon extends Model
{
    use SoftDeletes;
    use Userstamps;
    protected $fillable = ['name', 'code', 'type', 'minimum_amount', 'uses_customer', 'uses_total', 'balance', 'start_date', 'expiry_date', 'discount_type', 'discount', 'maximum_discount_amount', 'status'];
    protected $dates = ['deleted_at'];

    public function categories()
    {
        return $this->hasMany('App\Model\CouponCategory');
    }

}
