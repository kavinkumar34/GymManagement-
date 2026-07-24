<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutExercise extends Model
{
    protected $table = 'workout_exercises';

    protected $fillable = [
        'workout_plan_id',
        'day',
        'exercise_name',
        'sets',
        'reps',
        'weight',
        'rest_time',
        'exercise_image',
        'exercise_video',
        'trainer_notes',
        'display_order'
    ];

    public function workoutPlan()
    {
        return $this->belongsTo(WorkoutPlan::class, 'workout_plan_id');
    }
}