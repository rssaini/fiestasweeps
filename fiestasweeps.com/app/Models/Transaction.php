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
        'deposit_handle_id',
        'handle_id',
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
    public function depositHandle()
    {
        return $this->belongsTo('App\Models\PaymentHandle', 'deposit_handle_id');
    }
    public function handle()
    {
        return $this->belongsTo('App\Models\PaymentHandle', 'handle_id');
    }
}
