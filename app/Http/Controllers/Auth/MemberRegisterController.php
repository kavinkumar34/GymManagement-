<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OTPService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MemberRegisterController extends Controller
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function showRegisterForm()
    {
        return view('auth.member-register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'captcha' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->captcha != session('captcha')) {
            return redirect()->back()
                ->with('error', 'Invalid captcha code. Please try again.')
                ->withInput();
        }

        try {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'is_verified' => false,
            ]);

            // Generate OTP
            $otp = $user->generateOTP();

            Log::info('📱 OTP Generated', [
                'user_id' => $user->id,
                'otp' => $otp,
                'phone' => $user->phone
            ]);

            // Send OTP via SMS to the user's phone
            $result = $this->otpService->sendOTP($user->phone, $otp);

            Log::info('📤 SMS Sending Result', [
                'success' => $result['success'],
                'message' => $result['message'] ?? ''
            ]);

            // Store OTP in session (always)
            session(['test_otp' => $otp]);

            // Always redirect to OTP verification page
            return redirect()->route('verify.otp.form', ['user_id' => $user->id])
                ->with('success', '✅ OTP sent to your phone number!')
                ->with('test_otp', $otp);

        } catch (\Exception $e) {
            Log::error('❌ Registration Error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Registration failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showOTPForm($userId)
    {
        $user = User::findOrFail($userId);
        $otp = session('test_otp') ?? $user->otp;
        return view('auth.verify-otp', compact('user', 'otp'));
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::findOrFail($request->user_id);

        if ($user->verifyOTP($request->otp)) {
            Auth::login($user);
            session()->forget('test_otp');
            return redirect()->route('home')
                ->with('success', '✅ Registration successful! Welcome to Gym Management.');
        }

        return redirect()->back()
            ->with('error', '❌ Invalid OTP. Please try again.')
            ->withInput();
    }

    public function resendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid user'], 400);
        }

        $user = User::findOrFail($request->user_id);

        if ($user->is_verified) {
            return response()->json(['error' => 'User already verified'], 400);
        }

        $otp = $user->generateOTP();
        $result = $this->otpService->sendOTP($user->phone, $otp);
        session(['test_otp' => $otp]);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'OTP resent successfully to your phone',
                'test_otp' => $otp
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP generated (SMS failed - use test OTP)',
            'test_otp' => $otp
        ]);
    }
}