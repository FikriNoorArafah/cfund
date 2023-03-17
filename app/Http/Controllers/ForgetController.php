<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\Company;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class ForgetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['sendEmailUser', 'otpUser', 'resetUser', 'sendEmailCompany', 'otpCompany', 'resetCompany']]);
    }

    public function sendEmailUser(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak terdaftar'
                ]);
            }

            $otp = random_int(100000, 999999);

            $password_reset = PasswordReset::updateOrCreate(
                ['email' => $request->email],
                ['token' => Hash::make($otp), 'created_at' => now()]
            );


            Mail::to($request->email)->send(new ResetPassword($otp));

            return response()->json([
                'success' => true,
                'message' => 'OTP has been sent to your email!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function otpUser(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required',
                'email' => 'required|email'
            ]);

            $otp = PasswordReset::where('email', $request->email)
                ->where('created_at', '>', Carbon::now()->subMinutes(5))
                ->latest()
                ->firstOrFail();

            if (!Hash::check($request->otp, $otp->token)) {
                throw new \Exception('Invalid OTP');
            }

            return response()->json([
                'success' => true,
                'message' => 'berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function resetUser(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            $user = User::where('email', $request->email)->firstOrFail();
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Your password has been reset.'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function sendEmailCompany(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            $user = Company::where('email', $request->email)->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email tidak terdaftar'
                ]);
            }

            $otp = random_int(100000, 999999);

            $password_reset = PasswordReset::updateOrCreate(
                ['email' => $request->email],
                ['token' => Hash::make($otp), 'created_at' => now()]
            );


            Mail::to($request->email)->send(new ResetPassword($otp));

            return response()->json([
                'success' => true,
                'message' => 'OTP has been sent to your email!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function otpCompany(Request $request)
    {
        try {
            $request->validate([
                'otp' => 'required',
                'email' => 'required|email'
            ]);

            $otp = PasswordReset::where('email', $request->email)
                ->where('created_at', '>', Carbon::now()->subMinutes(5))
                ->latest()
                ->firstOrFail();

            if (!Hash::check($request->otp, $otp->token)) {
                throw new \Exception('Invalid OTP');
            }

            return response()->json([
                'success' => true,
                'message' => 'berhasil'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function resetCompany(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8',
            ]);

            $user = Company::where('email', $request->email)->firstOrFail();
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Your password has been reset.'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
