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
        'price',
        'cost_price',
        'mrp',
        'gst_percentage',
        'gst_amount',
        'total_price',
        'final_price',
        'discount_type',
        'discount_value',
        'discount_amount',
        'stock'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'gst_percentage' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'total_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'stock' => 'integer',
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}