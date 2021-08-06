<?php

namespace Modules\BlocksLandingPage\Entities;
use Illuminate\Database\Eloquent\Model;

class BlockCategory extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'color',
        'created_at',
        'updated_at',
    ];

    public function blocks()
    {
        return $this->hasMany('Modules\BlocksLandingPage\Entities\Block');
    }

    protected static function boot() {
        parent::boot();
        static::deleting(function($category) {
             if ($category->blocks()->count() > 0) {
                return false;
            }
        });

    }
   
 
}
