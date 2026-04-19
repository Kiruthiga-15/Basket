<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VariationValue extends Model
{
    protected $fillable = [
        'variation_type_id',
        'value_name',
        'value_type',
        'color_code',
        'status'
    ];

    public function type()
    {
        return $this->belongsTo(VariationType::class, 'variation_type_id');
    }
}