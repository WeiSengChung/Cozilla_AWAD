<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecific extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', // and other specific fields like size, color, etc.
    ];

    /**
     * A product specific belongs to one product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
