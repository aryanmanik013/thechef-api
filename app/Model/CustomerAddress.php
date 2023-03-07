<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerAddress extends Model
{
    use SoftDeletes;

    protected $table = 'customer_addresses';

    protected $fillable = ['customer_id', 'name', 'phone', 'country_id', 'state_id', 'city', 'locality', 'address', 'address_line_1', 'address_line_2', 'landmark', 'street_name', 'additional_phone', 'latitude', 'longitude', 'address_type', 'default_status'];

    protected $dates = ['deleted_at'];

    public function state()
    {
        return $this->belongsTo('App\Model\State', 'state_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('App\Model\Country', 'country_id', 'id');
    }

}
