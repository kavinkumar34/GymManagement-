<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';
    
    protected $fillable = [
        'product_id', 'color', 'images'
    ];
    
    protected $casts = [
        'images' => 'array'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function sizes()
    {
        return $this->hasMany(VariantSize::class, 'variant_id');
    }
}