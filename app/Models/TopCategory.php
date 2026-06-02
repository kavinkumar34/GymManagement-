<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopCategory extends Model
{
    protected $table = 'top_categories';
    
    protected $fillable = [
        'name', 'slug', 'gst_rate', 'description', 'is_active'
    ];
    
    protected $casts = [
        'gst_rate' => 'decimal:2',
        'is_active' => 'boolean'
    ];
    
    public function categories()
    {
        return $this->hasMany(Category::class, 'top_category_id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'top_category_id');
    }
}