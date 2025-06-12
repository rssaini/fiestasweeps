<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $table = 'payment_gateways';

    public function handles()
    {
        return $this->hasMany('App\Models\PaymentHandle', 'gateway_id');
    }

}
