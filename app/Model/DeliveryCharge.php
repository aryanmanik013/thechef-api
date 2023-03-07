<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryCharge extends Model
{
    use SoftDeletes;

    protected $fillable = ['state_id', 'country_id', 'charge', 'minimum_charge', 'minimum_distance', 'start_date', 'end_date', 'status'];
    //protected $dates = ['deleted_at'];

    public function state()
    {
        return $this->belongsTo('App\Model\State', 'state_id', 'id');
    }
}
