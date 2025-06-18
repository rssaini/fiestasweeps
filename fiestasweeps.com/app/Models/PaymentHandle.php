<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentHandle extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'gateway_id',
        'account_name',
        'account_handle',
        'description',
        'status',
        'daily_limit',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $table = 'payment_handles';

    public function gateway()
    {
        return $this->belongsTo('App\Models\PaymentGateway', 'gateway_id');
    }
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_handles', 'handle_id', 'user_id');
    }
    public function userHandles()
    {
        return $this->hasMany('App\Models\UserHandle', 'handle_id');
    }

}
