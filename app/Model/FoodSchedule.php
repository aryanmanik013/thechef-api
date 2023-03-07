<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodSchedule extends Model
{

    use SoftDeletes;

    protected $fillable = ['kitchen_id', 'day', 'time', 'status'];

    public function scheduledFood()
    {
        return $this->hasMany('App\Model\ScheduledFood', 'food_schedule_id', 'id');
    }
}
