<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    protected $fillable = [
        'package_name',
        'description',
        'price',
        'duration',
        'duration_type',
        'included_features',
        'status',
    ];

    // Get included features as array
    public function getFeaturesArrayAttribute()
    {
        if ($this->included_features) {
            return explode("\n", $this->included_features);
        }
        return [];
    }

    // Scope for active packages
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
}