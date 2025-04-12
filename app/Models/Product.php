<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'gender_category',
        'top_bottom_category',
        'clothes_category',
        'image_path'
    ];

    /**
     * A product has many product specifics.
     */
    public function specifics()
    {
        return $this->hasMany(ProductSpecific::class);
    }
}
