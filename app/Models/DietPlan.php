<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietPlan extends Model
{
    use HasFactory;

    protected $table = 'diet_plans';

    protected $fillable = [
        'trainer_id',
        'member_id',
        'title',
        'goal',
        'description',
        'start_date',
        'end_date',
        'status'
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function meals()
    {
        return $this->hasMany(DietMeal::class, 'diet_plan_id');
    }
}