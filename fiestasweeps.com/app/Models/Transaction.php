<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
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
        return $this->belongsTo('App\Models\Game', 'game_id')->withTrashed();
    }
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by')->withTrashed();
    }
    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by')->withTrashed();
    }
    public function depositHandle()
    {
        return $this->belongsTo('App\Models\PaymentHandle', 'deposit_handle_id')->withTrashed();
    }
    public function handle()
    {
        return $this->belongsTo('App\Models\PaymentHandle', 'handle_id')->withTrashed();
    }
}
