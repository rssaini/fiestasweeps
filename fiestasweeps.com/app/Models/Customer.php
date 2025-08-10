<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['customer_id'];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $table = 'customers';

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
