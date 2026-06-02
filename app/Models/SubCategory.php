<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $table = 'sub_categories';
    
    protected $fillable = [
        'name', 'slug', 'category_id', 'image', 'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function productTypes()
    {
        return $this->hasMany(ProductType::class, 'sub_category_id');
    }
    
    public function products()
    {
        return $this->hasMany(Product::class, 'sub_category_id');
    }
    
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'sub_category_attributes')
                    ->withPivot('is_required', 'display_order');
    }
}