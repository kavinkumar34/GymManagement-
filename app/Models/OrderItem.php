<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    
    protected $fillable = [
        'order_id', 'product_id', 'product_name', 'quantity', 'price'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    // Add this relationship
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}