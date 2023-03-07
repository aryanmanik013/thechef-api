<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;

class Banner extends Model
{
    use SoftDeletes;
    use Mediable;

    protected $fillable = ['activity', 'parameter', 'store_id', 'sort_order', 'status'];

    protected $dates = ['deleted_at'];

    public function parameter()
    {
        return $this->belongsTo('App\Model\Information');
    }
}
