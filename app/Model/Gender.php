<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

//use Spatie\Translatable\HasTranslations;

class Gender extends Model
{
    //use HasTranslations;
    public $translatable = ['name'];
    protected $fillable = ['name', 'sort_order', 'status'];

}
