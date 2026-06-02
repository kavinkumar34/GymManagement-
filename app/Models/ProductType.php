<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    protected $table = 'product_types';
    
    protected $fillable = [
        'name', 'slug', 'sub_category_id', 'image', 'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean'
    ];
    
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'product_type_id');
    }
}