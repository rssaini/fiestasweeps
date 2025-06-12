<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHandle extends Model
{
    protected $fillable = [
        'handle_id',
        'user_id',
    ];

    protected $table = 'user_handles';
    public $timestamps = false;

    public function handle()
    {
        return $this->belongsTo('App\Models\PaymentHandle', 'handle_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
