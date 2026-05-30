<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    
    protected $fillable = [
        'name', 'icon', 'status'
    ];
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('status', 'Active');
    }
}