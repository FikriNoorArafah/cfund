<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Http\Requests\ForgotPasswordRequest;
use App\Mail\ResetPassword;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Carbon;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = random_int(100000, 999999);
        $password_reset = new PasswordReset();
        $password_reset->email = $request->email;
        $password_reset->token = Hash::make($otp);
        $password_reset->created_at = now();
        $password_reset->save();

        Mail::to($request->email)->send(new ResetPassword($otp));

        return response()([
            'success' => true,
            'message' => 'OTP has been sent to your email!'
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        return response()([
            'success' => true,
            'message' => 'Your password has been reset.'
        ]);
    }

    public function otp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'email' => 'required|email'
        ]);

        $otp = PasswordReset::where('email', $request->email)
            ->where('created_at', '>', Carbon::now()->subMinutes(2))
            ->latest()
            ->first();

        if (!$otp || !Hash::check($request->otp, $otp->token)) {
            return response()([
                'success' => false,
                'message' => 'Invalid OTP'
            ]);
        }
        return response()([
            'success' => true,
            'message' => 'berhasil'
        ]);
    }
}
