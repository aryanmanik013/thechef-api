<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use SoftDeletes;
    use HasTranslations;

    protected $fillable = ['question', 'answer', 'status', 'sort_order', 'type'];
    public $translatable = ['question', 'answer'];

    //protected $dates = ['deleted_at'];
}
