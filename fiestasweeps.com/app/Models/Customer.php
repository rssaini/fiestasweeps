<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'customer_id',
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'citizenship',
        'email_address',
        'phone_number',
        'address1',
        'address2',
        'address_city',
        'address_state_region',
        'address_postal_code',
        'address_country_code',
        'identity_accuracy_score',
        'fraud_score',
    ];

    protected function casts(): array
    {
        return [
            'identity_accuracy_score' => 'decimal:4',
            'fraud_score' => 'decimal:4',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sessionsRequests(): HasMany
    {
        return $this->hasMany(SessionRequest::class, 'customer_id', 'customer_id');
    }

    public function sessionResponses(): HasMany
    {
        return $this->hasMany(SessionResponse::class, 'customer_id', 'customer_id');
    }

    public function customerStatuses(): HasMany
    {
        return $this->hasMany(CustomerStatus::class, 'customer_id', 'customer_id');
    }

    public function customerFlags(): HasMany
    {
        return $this->hasMany(CustomerFlag::class, 'customer_id', 'customer_id');
    }

    public function customerMonitors(): HasMany
    {
        return $this->hasMany(CustomerMonitor::class, 'customer_id', 'customer_id');
    }

    public function locations(): HasMany
    {
        return $this->hasMany(Location::class, 'customer_id', 'customer_id');
    }
}
