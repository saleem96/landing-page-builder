<?php

namespace Modules\BlocksLandingPage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Block extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'block_category_id',
        'name',
        'thumb', // like type template
        'content',
        'style',
        'active',
        'created_at',
        'updated_at',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    public function getReplaceVarBlockContent() {
        
        return replaceVarContentStyle($this->content);
    }

    public function category()
    {
        return $this->belongsTo('Modules\BlocksLandingPage\Entities\BlockCategory', 'block_category_id');
    }

 
}
