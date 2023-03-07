<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Wildside\Userstamps\Userstamps;

class Country extends Model
{
    use SoftDeletes;
    use HasTranslations;
    use Userstamps;
    protected $fillable = ['name', 'iso_code_2', 'iso_code_3', 'currency_code', 'phone_prefix', 'status'];
    public $translatable = ['name'];
    protected $dates = ['deleted_at'];

//      public function currency()
    //     {
    //       return $this->belongsTo('App\Model\Currency','currency_code','code');
    //     }
}
