<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliverablePincode extends Model
{
    use HasFactory;
    
    protected $table = 'deliverable_pincodes';
    
    protected $fillable = [
        'pincode', 'city', 'state', 'delivery_days', 'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'delivery_days' => 'integer'
    ];
    
    public static function isDeliverable($pincode)
    {
        return self::where('pincode', $pincode)
            ->where('is_active', 1)
            ->exists();
    }
    
    public static function getDeliveryInfo($pincode)
    {
        return self::where('pincode', $pincode)
            ->where('is_active', 1)
            ->first();
    }
}