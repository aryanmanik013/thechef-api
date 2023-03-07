<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Plank\Mediable\Mediable;
use Spatie\Translatable\HasTranslations;

class FoodCategory extends Model
{

    use SoftDeletes;
    use HasTranslations;
    use NodeTrait, Mediable {
        NodeTrait::newCollection insteadof Mediable;
    }

    protected $fillable = ['name', 'parent_id', 'description', 'sort_order', 'status', '_lft', '_rgt', 'popular'];
    public $translatable = ['name', 'description'];
}
