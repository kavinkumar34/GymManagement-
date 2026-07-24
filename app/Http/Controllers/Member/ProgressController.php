<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Progress;
use Illuminate\Support\Facades\Session;

class ProgressController extends Controller
{
    public function index()
    {
        $memberId = Session::get('gym_user_id');

        $progress = Progress::with('trainer')
            ->where('member_id', $memberId)
            ->latest()
            ->paginate(10);

        return view('member.progress.index', compact('progress'));
    }
}