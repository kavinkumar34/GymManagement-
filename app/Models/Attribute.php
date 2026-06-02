<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table = 'attributes';
    
    protected $fillable = [
        'name', 'label', 'slug', 'type', 'placeholder', 'required', 'is_global', 'status'
    ];
    
    protected $casts = [
        'required' => 'boolean',
        'is_global' => 'boolean'
    ];
    
    public function values()
    {
        return $this->hasMany(AttributeValue::class)->orderBy('display_order');
    }
    
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_attributes')
                    ->withPivot('is_required', 'display_order');
    }
    
    public function subCategories()
    {
        return $this->belongsToMany(SubCategory::class, 'sub_category_attributes')
                    ->withPivot('is_required', 'display_order');
    }
}