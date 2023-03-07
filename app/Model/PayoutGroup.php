<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayoutGroup extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['name', 'type', 'payment_frequency', 'payment_date', 'day_id', 'percentage', 'sort_order', 'status'];

    public function day()
    {

        return $this->belongsTo('App\Model\Day', 'day_id', 'id');
    }
}
