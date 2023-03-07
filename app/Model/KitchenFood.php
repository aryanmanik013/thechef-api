<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Plank\Mediable\Mediable;
use Spatie\Translatable\HasTranslations;

class KitchenFood extends Model
{
    use HasTranslations;
    use SoftDeletes;
    use Mediable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'kitchen_id', 'veg_status', 'recipe_details', 'price', 'quantity', 'status', 'available_time',
    ];
    public $translatable = [''];

    public function kitchen()
    {
        return $this->belongsTo('App\Model\Kitchen', 'kitchen_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany('App\Model\KitchenFoodCategory');
    }

}
