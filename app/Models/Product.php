<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{ 
    protected $fillable = [

        'category_id',

        'name', 
        'slug',
        'price',
        'discount_price',

        'sku',
        'stock',

        'delivery_charge',

        'discount_type',
        'discount_value',

        'main_image',

        'short_description',
        'long_description',

        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}