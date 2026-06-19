<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    protected $table = 'product_variants';
    
    protected $fillable = [
        'product_id', 
        'size', 
        'color', 
        'value', 
        'price', 
        'stock'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}   