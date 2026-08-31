<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $table = 'trainers';
    
    protected $fillable = [
        'trainer_id', 'name', 'gender', 'dob', 'age', 'phone', 'email', 'address',
        'experience', 'specialization', 'salary', 'join_date', 'shift_timing',
        'certification', 'assigned_members', 'photo', 'status'
    ];
    
    // Get members assigned to this trainer
    public function members()
    {
        return $this->hasMany(Member::class, 'trainer_id');
    }
        // Get assigned members count
    public function getMemberCountAttribute()
    {
        return $this->members()->count();
    }
    public function memberAttendances()
{
    return $this->hasMany(MemberAttendance::class, 'trainer_id');
}

public function trainerAttendances()
{
    return $this->hasMany(TrainerAttendance::class, 'trainer_id');
}

// Add relationship
public function salaries()
{
    return $this->hasMany(TrainerSalary::class);
}

// Add accessor for total salary received
public function getTotalSalaryReceivedAttribute()
{
    return $this->salaries()->sum('salary_amount');
}

// Add accessor for total salary this month
public function getThisMonthSalaryAttribute()
{
    return $this->salaries()
        ->whereYear('salary_month', now()->year)
        ->whereMonth('salary_month', now()->month)
        ->sum('salary_amount');
}
}