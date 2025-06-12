<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'player_id',
        'game_id',
        'amount',
        'points',
        'created_by',
        'updated_by',
        'last_deposit',
        'deposit_gateway_id',
        'gateway_id',
        'player_handle',
        'transaction_type',
        'status',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $table = 'transactions';

    public function game()
    {
        return $this->belongsTo('App\Models\Game', 'game_id');
    }
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }
    public function depositGateway()
    {
        return $this->belongsTo('App\Models\PaymentHandle', 'deposit_gateway_id');
    }
    public function gateway()
    {
        return $this->belongsTo('App\Models\PaymentGateway', 'gateway_id');
    }
}
