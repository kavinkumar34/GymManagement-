<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 
        'discount_price', 'stock', 'image', 'images', 
        'is_featured', 'is_best_seller', 'status'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function getDiscountPercentAttribute()
    {
        if ($this->price > 0 && $this->discount_price) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }
}