<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'progress';

    protected $fillable = [
        'trainer_id',
        'member_id',
        'weight',
        'height',
        'bmi',
        'body_fat',
        'chest',
        'waist',
        'hips',
        'left_arm',
        'right_arm',
        'left_thigh',
        'right_thigh',
        'before_photo',
        'after_photo',
        'notes',
        'progress_date'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }
}