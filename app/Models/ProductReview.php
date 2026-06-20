<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $table = 'product_reviews';
    
    protected $fillable = [
        'user_id', 'order_id', 'product_id', 'rating', 
        'description', 'images', 'videos', 'status'
    ];
    
    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
        'rating' => 'integer',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}