<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class KitchenFavorite extends Model
{
    protected $fillable = ['customer_id', 'kitchen_id'];

    public function Kitchen()
    {
        return $this->belongsTo('App\Model\Kitchen');
    }
}
