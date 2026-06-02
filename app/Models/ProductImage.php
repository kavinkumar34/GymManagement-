<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    
    protected $fillable = [
        'product_id', 'image_path', 'is_main', 'display_order', 'alt_text'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}