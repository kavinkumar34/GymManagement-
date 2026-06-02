<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    
    protected $fillable = [
        'name', 'slug', 'logo', 'description', 'seller_id', 'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean'
    ];
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}