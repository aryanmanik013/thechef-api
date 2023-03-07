<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DeliveryPartnerPayouts extends Model
{
    //

    protected $fillable = ['delivery_partner_id', 'payout_group_id', 'total_orders', 'total_amount', 'payout_method', 'start_date', 'end_date', 'payout_generated_date', 'payable_amount', 'commission', 'status', 'transaction_id', 'remarks'];

    public function deliveryPartner()
    {

        return $this->belongsTo('App\Model\DeliveryPartner', 'delivery_partner_id', 'id');
    }
    public function payoutGroup()
    {

        return $this->belongsTo('App\Model\PayoutGroup', 'payout_group_id', 'id');
    }
}
