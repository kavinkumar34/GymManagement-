<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_types';
    
    protected $fillable = [
        'name',
        'category_id',
        'image',
        'is_active'
        // Remove 'slug' from here
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Remove any boot() method that creates slug
    // Remove any slug-related methods

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}