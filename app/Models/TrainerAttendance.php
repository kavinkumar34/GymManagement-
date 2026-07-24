<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainerAttendance extends Model
{
    protected $table = 'trainer_attendance';

    protected $fillable = [
        'trainer_id',
        'attendance_date',
        'status',
        'check_in',
        'check_out',
        'remarks'
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
}