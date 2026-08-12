<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'This email address is not registered with us.'
        ]);

        $user = User::where('email', $request->email)->first();
        
        $token = Str::random(64);
        $user->otp = $token;
        $user->otp_expires_at = Carbon::now()->addHours(24);
        $user->save();

        $resetLink = route('password.reset-form', ['token' => $token, 'email' => $user->email]);
        
        try {
            Mail::send('emails.reset-password', [
                'name' => $user->name,
                'resetLink' => $resetLink
            ], function($message) use ($user) {
                $message->to($user->email)
                        ->subject('Reset Your Password - FitForge');
            });

            return redirect()->route('login')
                            ->with('success', 'Password reset link has been sent to your email.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send reset link. Please try again.');
        }
    }

    public function showResetForm($token, $email)
    {
        $user = User::where('email', $email)
                    ->where('otp', $token)
                    ->where('otp_expires_at', '>', Carbon::now())
                    ->first();

        if (!$user) {
            return redirect()->route('password.request')
                           ->with('error', 'Invalid or expired reset link.');
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)
                    ->where('otp', $request->token)
                    ->where('otp_expires_at', '>', Carbon::now())
                    ->first();

        if (!$user) {
            return back()->with('error', 'Invalid or expired reset link.');
        }

        $user->password = bcrypt($request->password);
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        return redirect()->route('login')
                        ->with('success', 'Password reset successfully! Please login.');
    }
}