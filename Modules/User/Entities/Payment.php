<?php

namespace Modules\User\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'email',
        'amount',
        'currency' ,
        'transaction_id',
        'payment_status',
        'receipt_url',
        'transaction_complete_details',
    ]; 

}
