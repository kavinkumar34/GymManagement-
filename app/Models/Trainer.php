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
}