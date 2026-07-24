<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Trainer;
use App\Models\Member;
use App\Models\WorkoutExercise;

class WorkoutPlan extends Model
{
    protected $table = 'workout_plans';

    protected $fillable = [
        'trainer_id',
        'member_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'status'
    ];

    /**
     * Trainer Relationship
     */
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id', 'id');
    }

    /**
     * Member Relationship
     */
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    /**
     * Workout Exercises
     */
    public function exercises()
    {
        return $this->hasMany(WorkoutExercise::class, 'workout_plan_id', 'id');
    }
}