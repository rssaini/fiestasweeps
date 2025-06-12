<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'parent_id',
        'password',
        'lname',
        'phone',
        'dob',
        'online_stats',
        'marketting_stats',
        'game_stats',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    public function userHandle()
    {
        return $this->hasOne(UserHandle::class, 'user_id');
    }
    public function paymentHandles()
    {
        return $this->hasManyThrough(PaymentHandle::class, UserHandle::class, 'user_id', 'id', 'id', 'handle_id');
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->lname;
    }
}
