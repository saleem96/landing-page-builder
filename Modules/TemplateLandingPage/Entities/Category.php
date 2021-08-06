<?php

namespace Modules\TemplateLandingPage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Category extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'group_category_id',
        'thumb',
        'color',
        'created_at',
        'updated_at',
    ];
    public function groupcategory()
    {
        return $this->belongsTo('Modules\TemplateLandingPage\Entities\GroupCategory', 'group_category_id');
    }

    public function templates()
    {
        return $this->hasMany('Modules\TemplateLandingPage\Entities\Template');
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($category) {
             if ($category->templates()->count() > 0) {
                return false;
            }
        });

    }
   
 
}
