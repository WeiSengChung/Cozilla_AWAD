<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    protected $fillable = [
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * One user has one user profile.
     */
    public function userprofile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * One user has many addresses.
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * One user has one cart.
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    /**
     * One user has many orders.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
