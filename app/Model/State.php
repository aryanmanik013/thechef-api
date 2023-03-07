<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;
use Wildside\Userstamps\Userstamps;

class State extends Model
{
    use SoftDeletes;
    use HasTranslations;
    use Userstamps;
    protected $fillable = ['country_id', 'name', 'code', 'status'];

    protected $dates = ['deleted_at'];
    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }
    public $translatable = ['name'];

}
