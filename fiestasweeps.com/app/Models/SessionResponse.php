<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SessionResponse extends Model
{
    protected $table = 'session_responses';
    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'service_type',
        'customer_id',
        'reason_codes',
        'session_response_raw',
    ];

    public function sessionRequest(): BelongsTo
    {
        return $this->belongsTo(SessionRequest::class, 'session_id', 'session_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
