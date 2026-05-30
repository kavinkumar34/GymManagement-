<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrainerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'trainer') {
            return $next($request);
        }
        return redirect('/login')->with('error', 'Access denied. Trainer only.');
    }
}