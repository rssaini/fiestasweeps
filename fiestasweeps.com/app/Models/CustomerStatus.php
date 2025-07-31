<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerStatus extends Model
{
    protected $table = 'customer_statuses';

    protected $fillable = [
        'session_id',
        'customer_id',
        'identity_status',
    ];

    protected function casts(): array
    {
        return [
            'identity_status' => 'boolean',
        ];
    }

    public function sessionRequest(): BelongsTo
    {
        return $this->belongsTo(SessionRequest::class, 'session_id', 'session_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
