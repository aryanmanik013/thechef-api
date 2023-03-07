<?php
//SAMAH
namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class KitchenDetails extends Model
{
    use SoftDeletes;
    use HasTranslations;

    protected $fillable = ['specialities', 'description', 'about', 'order_policy', 'delivery_policy', 'payment_terms', 'kitchen_id'];
    public $translatable = ['specialities', 'description', 'about', 'order_policy', 'delivery_policy', 'payment_terms'];

    protected $dates = ['deleted_at'];
    public function kitchen()
    {
        return $this->belongsTo('App\Model\Kitchen', 'kitchen_id', 'id');
    }
}
