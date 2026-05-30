<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;

class TrainerDashboardController extends Controller
{
    public function index()
    {
        return view('trainer.dashboard');
    }
}