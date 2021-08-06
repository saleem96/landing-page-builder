<?php

namespace Modules\TemplateLandingPage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Template extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'category_id',
        'name',
        'thumb', // like type template
        'content',
        'style',
        'thank_you_page',
        'thank_you_style',
        'active',
        'is_premium',
        'created_at',
        'updated_at',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_premium' => 'boolean',
        'active' => 'boolean',
    ];


    public function category()
    {
        return $this->belongsTo('Modules\TemplateLandingPage\Entities\Category', 'category_id');
    }
 
}
