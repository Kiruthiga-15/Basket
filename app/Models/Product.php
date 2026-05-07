<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [

        'category_id',

        'variation_type_size_id',
        'variation_value_size_id',

       'variation_type_color_id',
        'variation_value_color_id',

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

    public function variationType()
    {
        return $this->belongsTo(
            VariationType::class
        );
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variationTypeSize()
    {
        return $this->belongsTo(VariationType::class, 'variation_type_size_id');
    }

    public function variationValueSize()
    {
        return $this->belongsTo(VariationValue::class, 'variation_value_size_id');
    }

    public function variationTypeColor()
    {
        return $this->belongsTo(VariationType::class, 'variation_type_color_id');
    }

    public function variationValueColor()
    {
        return $this->belongsTo(VariationValue::class, 'variation_value_color_id');
    }

    // Size Value
    public function sizeValue()
    {
        return $this->belongsTo(
            \App\Models\VariationValue::class,
            'variation_value_size_id'
        );
    }

    // Color Value
    public function colorValue()
    {
        return $this->belongsTo(
            \App\Models\VariationValue::class,
            'variation_value_color_id'
        );
    }
    
}