<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietMeal extends Model
{
    use HasFactory;

    protected $table = 'diet_meals';

    protected $fillable = [
        'diet_plan_id',
        'day',
        'meal_time',
        'food_name',
        'quantity',
        'calories',
        'protein',
        'carbs',
        'fats',
        'notes'
    ];

    public function dietPlan()
    {
        return $this->belongsTo(DietPlan::class, 'diet_plan_id');
    }
}