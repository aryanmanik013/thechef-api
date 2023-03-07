<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{

    protected $fillable = [
        'user_id', 'user_type', 'token',
    ];

}
