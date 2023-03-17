<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgetController extends Controller
{
    public function sendEmail(Request $request)
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

    
}
