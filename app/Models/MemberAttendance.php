<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberAttendance extends Model
{
    protected $table = 'member_attendance';

    protected $fillable = [
        'trainer_id',
        'member_id',
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

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}