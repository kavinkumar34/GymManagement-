<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $table = 'categories';
    
    protected $fillable = [
        'name', 'slug', 'top_category_id', 'icon', 'image', 'parent_id', 
        'level', 'display_order', 'status', 'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'level' => 'integer',
        'display_order' => 'integer'
    ];
    
    // Relationship with TopCategory
    public function topCategory()
    {
        return $this->belongsTo(TopCategory::class, 'top_category_id');
    }
    
    // Self-referencing for parent-child
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    
    // Relationship with SubCategory
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id');
    }
    
    // Relationship with Products
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    
    // Relationship with Attributes
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'category_attributes')
                    ->withPivot('is_required', 'display_order')
                    ->orderBy('category_attributes.display_order');
    }
}