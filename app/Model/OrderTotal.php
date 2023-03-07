<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderTotal extends Model
{
    protected $fillable = ['order_id', 'title', 'code', 'value', 'sort_order'];
}
