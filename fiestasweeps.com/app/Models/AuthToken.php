<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthToken extends Model
{
    protected $fillable = ['token', 'user_id', 'expires_at', 'used'];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generateForUser($userId, $expiresInMinutes = 5)
    {
        // Clean up expired tokens
        static::where('expires_at', '<', now())->delete();

        // Generate unique token
        $token = Str::random(32);

        return static::create([
            'token' => $token,
            'user_id' => $userId,
            'expires_at' => Carbon::now()->addMinutes($expiresInMinutes),
        ]);
    }

    public static function cleanupExpired(){
        static::where('expires_at', '<', now())->delete();
    }

    public function isValid()
    {
        return !$this->used && $this->expires_at > now();
    }

    public function markAsUsed()
    {
        $this->update(['used' => true]);
    }
}
