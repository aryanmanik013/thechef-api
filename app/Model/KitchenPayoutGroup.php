<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KitchenPayoutGroup extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['payment_frequency', 'payment_date', 'day_id', 'percentage', 'sort_order', 'status'];

    public function day()
    {

        return $this->belongsTo('App\Model\Day', 'day_id', 'id');
    }
}
