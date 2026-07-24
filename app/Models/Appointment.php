<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointments';

    protected $fillable = [
        'member_id',
        'trainer_id',
        'appointment_date',
        'appointment_time',
        'purpose',
        'description',
        'status',
        'trainer_remark'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
}