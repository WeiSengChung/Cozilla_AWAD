<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    //database name
    protected $table = 'contact_us';
    public $timestamps = false;

    protected $fillable = [
        'company_address',
        'email',
        'contact_number',
    ];
}
