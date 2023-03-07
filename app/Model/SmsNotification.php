<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SmsNotification extends Model
{

    //
    use SoftDeletes;
    protected $fillable = ['title', 'parameter', 'route', 'status', 'message', 'read_status', 'user_type', 'token', 'created_by'];
    protected $dates = ['deleted_at'];
    public function order()
    {
        return $this->belongsTo('App\Model\Order', 'order_id', 'id');
    }
}
