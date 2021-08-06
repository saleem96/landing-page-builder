<?php

namespace Modules\Ecommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class LandingpageOrder extends Model
{

    protected $dates = [
        'created_at',
        'updated_at',
    ];
        
    protected $fillable = [
        'user_id',
        'landing_page_id',
        'product_name',
        'reference',
        'gateway',
        'field_values',
        'total',
        'is_paid',
        'options',
        'currency',
        'status',
        'browser',
        'os',
        'device',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'field_values' => 'array',
    ];

    public function getTotalInCentsAttribute()
    {
        $arr_zero_decimal =  ['BIF','CLP','DJF','GNF','JPY','KMF','KRW','MGA','PYG','RWF','UGX','VND','VUV','XAF','XOF','XPF'];
        if (!in_array($this->currency, $arr_zero_decimal)) {
            return $this->total * 100;
        }
        return $this->total;
    }

    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\User','user_id');
    }

   
    public function landingpage()
    {
        return $this->belongsTo('Modules\LandingPage\Entities\LandingPage','landing_page_id');
    }

    public function scopePaid($query)
    {
        return $query->where('is_paid', '=', 1);
    }
    
}
