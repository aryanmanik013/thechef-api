<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes;

    protected $fillable = ['customer_id', 'kitchen_id', 'delivery_partner_id', 'title', 'description', 'source', 'type'];

    public function customer()
    {
        return $this->belongsTo('App\Model\Customer', 'customer_id', 'id');
    }

    public function kitchen()
    {
        return $this->belongsTo('App\Model\Kitchen', 'kitchen_id', 'id');
    }
    public function deliveryPartner()
    {
        return $this->belongsTo('App\Model\DeliveryPartner', 'delivery_partner_id', 'id');
    }
}
