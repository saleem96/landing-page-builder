<?php

namespace Modules\LandingPage\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;


class LandingPage extends Model
{
    
    private function generateCode()
    {
        $this->code = (string)Uuid::uuid1();
    }

    

    protected $dates = [
        'created_at',
        'updated_at',
    ];


    protected $fillable = [
        'user_id',
        'template_id',
        'name',
        'thank_you_page_html',
        'thank_you_page_css',
        'thank_you_page_components',
        'thank_you_page_styles',
        'html',
        'css',
        'components',
        'styles',
        'main_page_script',
        'favicon',
        'domain_type',
        'sub_domain',
        'custom_domain',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'social_title',
        'social_image',
        'social_description',
        'custom_header',
        'custom_footer',
        'redirect_url',
        'type_form_submit',
        'type_payment_submit',
        'redirect_url_payment',
        'is_publish',
        'is_trash',
        'settings',
        'created_at',
        'updated_at',
    ];
    

    protected $casts = [
        'settings' => 'array',
        'domain_type' => 'boolean',
        'is_publish' => 'boolean',
        'is_trash' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\User');
    }
    public function formdata()
    {
        return $this->hasMany('Modules\Forms\Entities\FormData');
    }
    public function template()
    {
        return $this->belongsTo('Modules\TemplateLandingPage\Entities\Template');
    }

    public function scopePublish($query)
    {
        return $query->where('is_publish', '=', 1);
    }
    public function scopeUnPublish($query)
    {
        return $query->where('is_publish', '=', 0);
    }
    public function scopeTrash($query)
    {
        return $query->where('is_trash', '=', 1);
    }
    public function scopeUnTrash($query)
    {
        return $query->where('is_trash', '=', 0);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (LandingPage $model) {
            $model->generateCode();
        });

        static::deleting(function($landingpage) { // before delete() method call this
             $landingpage->formdata()->each(function($item) {
                $item->delete();
             });
        });
    }
 
}
