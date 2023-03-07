<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KitchenPayouts extends Model
{
    //

    protected $fillable = ['kitchen_id', 'payout_group_id', 'total_orders', 'total_amount', 'payout_method', 'start_date', 'end_date', 'payout_generated_date', 'commission', 'payable_amount', 'status', 'transaction_id', 'remarks'];

    public function kitchen()
    {

        return $this->belongsTo('App\Model\Kitchen', 'kitchen_id', 'id');
    }
    public function payoutGroup()
    {

        return $this->belongsTo('App\Model\PayoutGroup', 'payout_group_id', 'id');
    }
}
