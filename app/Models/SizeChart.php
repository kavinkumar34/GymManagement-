<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeChart extends Model
{
    protected $table = 'size_charts';
    
    protected $fillable = [
        'title', 'gender', 'category_type', 'image', 'default_unit', 'sizes'
    ];
    
    protected $casts = [
        'sizes' => 'array'
    ];
    
    public function products()
    {
        return $this->hasMany(Product::class, 'size_chart_id');
    }
}