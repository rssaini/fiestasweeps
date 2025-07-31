<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Location extends Model
{
    protected $table = 'locations';
    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'customer_id',
        'location_detail',
    ];


    public function session(): BelongsTo
    {
        return $this->belongsTo(SessionRequest::class, 'session_id', 'session_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}
