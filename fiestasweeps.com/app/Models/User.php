<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable , HasRoles, HasApiTokens, SoftDeletes;

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

    protected $appends = ['role', 'parent_name', 'status_name'];

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

    public function setPhoneAttribute($value)
    {
        // Remove all non-digit characters
        $digits = preg_replace('/\D/', '', $value);
        // Format as (XXX) XXX-XXXX
        if (strlen($digits) == 10) {
            $formatted = sprintf('(%s) %s-%s',
                substr($digits, 0, 3),
                substr($digits, 3, 3),
                substr($digits, 6));
            $this->attributes['phone'] = $formatted;
        } else {
            // fallback if invalid length
            $this->attributes['phone'] = $value;
        }
    }

    // Mutator for date_of_birth
    public function setDobAttribute($value)
    {
        // Parse various formats and convert to mm/dd/yyyy
        $date = date_create($value);
        if ($date) {
            $this->attributes['dob'] = date_format($date, 'm/d/Y');
        } else {
            // fallback, store as is
            $this->attributes['dob'] = $value;
        }
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

    public function getRoleAttribute()
    {
        return $this->roles()->pluck('name')->first();
    }
    public function getParentNameAttribute()
    {
        return $this->parent()->pluck('name')->first();
    }
    public function getStatusNameAttribute()
    {
        return $this->status == 1 ? 'active' : 'inactive';
    }
}
