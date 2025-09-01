<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\OTP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create($validated);


        // ساخت کد 6 رقمی
        $otpCode = rand(100000, 999999);

        OTP::create([
            'phone' => $user->phone,
            'code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(5),
        ]);
// اینجا باید سرویس SMS خودتون رو صدا بزنید
        // مثلا SmsService::send($user->phone, "کد تایید: $otpCode");


        return response()->json(['message' => 'کد تایید ارسال شد.']);
    }

    public function verifyPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'otp' => 'required|string',
        ]);

        $verification = OTP::where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$verification) {
            return response()->json(['message' => 'کد نامعتبر یا منقضی شده'], 400);
        }

        $user = User::where('phone', $request->phone)->first();

        $user->update(['phone_verified_at' => now()]);
        // حذف OTP بعد از استفاده
        $verification->delete();
        // ایجاد توکن Sanctum
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'ورود موفق',
            'access_token' => $token,
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $otpCode = rand(100000, 999999);

        OTP::create([
            'phone' => $request->phone,
            'code' => $otpCode,
            'expires_at' => now()->addMinutes(5),
        ]);

        // ارسال پیامک با کد

        return response()->json(['message' => 'کد ورود ارسال شد.']);
    }
    public function logout(Request $request)
    {
        // حذف توکن جاری کاربر
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'خروج با موفقیت انجام شد.'
        ]);
    }
}
