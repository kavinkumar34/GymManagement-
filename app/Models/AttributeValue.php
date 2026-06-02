<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $table = 'attribute_values';
    
    protected $fillable = [
        'attribute_id', 'value', 'additional_price', 'display_order'
    ];
    
    protected $casts = [
        'additional_price' => 'decimal:2'
    ];
    
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}