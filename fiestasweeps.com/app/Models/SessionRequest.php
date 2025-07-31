<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SessionRequest extends Model
{
    protected $table = 'session_requests';

    protected $fillable = [
        'session_id',
        'service_type',
        'customer_id',
        'device_location',
        'session_request_raw',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }

    public function sessionResponses(): HasMany
    {
        return $this->hasMany(SessionResponse::class, 'session_id', 'session_id');
    }

    public function customerStatuses(): HasMany
    {
        return $this->hasMany(CustomerStatus::class, 'session_id', 'session_id');
    }

    public function customerMonitors(): HasMany
    {
        return $this->hasMany(CustomerMonitor::class, 'session_id', 'session_id');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'session_id', 'session_id');
    }
}
