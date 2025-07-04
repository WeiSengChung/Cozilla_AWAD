<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
    ];

    /**
     * Each user profile belongs to one user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
