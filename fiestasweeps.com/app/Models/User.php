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

    protected $appends = ['role', 'parent_name', 'status_name', 'current_balance', 'total_deposits', 'total_winnings'];

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
            'dob' => 'date',
        ];
    }

    public function getDobAttribute($value){
        return $value ? \Carbon\Carbon::parse($value)->format('Y-m-d') : null;
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
    public function getCurrentBalanceAttribute()
    {
        $balance = 0;
        try{
            $customer = Customer::where('users', $this->id)->firstOrFail();
            $balance = $customer->balance;
        }catch(\Exception $e){

        }

        return '$' . number_format($balance, 2);
    }
    public function getTotalDepositsAttribute()
    {
        $balance = 0;
        try{
            $customer = Customer::where('users', $this->id)->firstOrFail();
            $balance = $customer->total_deposited;
        }catch(\Exception $e){

        }
        return '$' . number_format($balance, 2);
    }
    public function getTotalWinningsAttribute()
    {
        $balance = 0;
        try{
            $customer = Customer::where('users', $this->id)->firstOrFail();
            $balance = $customer->total_winnings;
        }catch(\Exception $e){

        }
        return '$' . number_format($balance, 2);
    }
    public function getStatusNameAttribute()
    {
        return $this->status == 1 ? 'active' : 'inactive';
    }
}
