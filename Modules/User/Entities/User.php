<?php

namespace Modules\User\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $dates = [
        'email_verified_at',
        'package_ends_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_admin',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'settings',
        'package_id',
        'package_ends_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
        'settings' => 'array'

    ];
    
    public function pages()
    {
        return $this->hasMany('Modules\LandingPage\Entities\LandingPage');
    }
    
    public function payments()
    {
        return $this->hasMany('Modules\Saas\Entities\Payment');
    }

    public function package()
    {
        return $this->belongsTo('Modules\Saas\Entities\Package')->withDefault();
    }

    public function subscribed()
    {
        if (is_null($this->package_ends_at)) {
            return false;
        }
        return $this->package_ends_at->isFuture();
    }
    public function checkRemoveBrand()
    {
        if (!$this->subscribed()) {
            # code...
            if (config('saas.remove_branding') == true) {
                return true;
            }
            return false;
        }
        else{
            if ($this->package->remove_branding == true) {
                return true;
            }
            return false;
        }
    }
    public function checkCustomCode()
    {
        if (!$this->subscribed()) {
            # code...
            if (config('saas.custom_code') == true) {
                return true;
            }
            return false;
        }
        else{
            if ($this->package->custom_code == true) {
                return true;
            }
            return false;
        }
    }
    public function checkCustomDomain()
    {
        if (!$this->subscribed()) {
            # code...
            if (config('saas.custom_domain') == true) {
                return true;
            }
            return false;
        }
        else{

            if ($this->package->custom_domain == true) {
                return true;
            }
            return false;
        }
    }
    
    

    public static function boot() {
        parent::boot();

        static::deleting(function($user) { // before delete() method call this
             $user->pages()->each(function($item) {
                $item->delete();
             });
        });
    }
   
    
}
