<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    
    // Disable timestamps if your table doesn't have updated_at
    public $timestamps = true;  // Set to true if you have created_at and updated_at
    
    protected $fillable = [
        'product_id', 'image_path', 'is_main', 'display_order'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}