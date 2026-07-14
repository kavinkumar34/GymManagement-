<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    
    protected $fillable = [
        'order_id', 
        'product_id', 
        'variant_id',
        'product_name', 
        'quantity', 
        'price',
        'final_price', // ← ADD THIS
        'total',
        'size',
        'color',
        'product_image'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}