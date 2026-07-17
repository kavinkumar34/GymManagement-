<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $table = 'memberships';

    protected $fillable = [
        'plan_name',
        'image',
        'duration',
        'duration_type',
        'price',
        'discount_type',
        'discount',
        'final_price',
        'description',
        'status',
    ];
}