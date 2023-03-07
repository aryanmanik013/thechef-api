<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Information extends Model
{

    use HasTranslations;

    protected $fillable = ['title', 'short_description', 'description', 'sort_order', 'status', 'type'];
    public $translatable = ['title', 'short_description', 'description'];

}
