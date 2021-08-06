<?php

namespace Modules\TemplateLandingPage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class GroupCategory extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'thumb',
        'color',
        'created_at',
        'updated_at',
    ];

    public function categories()
    {
        return $this->hasMany('Modules\TemplateLandingPage\Entities\Category');
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($groupCategory) {
             if ($groupCategory->categories()->count() > 0) {
                return false;
            }
        });

    }
   
 
}
