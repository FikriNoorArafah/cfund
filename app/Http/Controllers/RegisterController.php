<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Mail\EmailVerify;
use App\Models\EmailVerification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $userData = $request->validated();

        $emailExist = User::where('email', $request->email)->exists();

        if ($emailExist) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah dipakai'
            ]);
        }

        $telephoneExist = User::where('telephone', $request->telephone)->exists();

        if ($telephoneExist) {
            return response()->json([
                'success' => false,
                'message' => 'Telepon sudah dipakai'
            ]);
        }

        $otp = random_int(100000, 999999);
        $emailverify = new EmailVerification();
        $emailverify->email = $request->email;
        $emailverify->token = Hash::make($otp);
        $emailverify->created_at = now();
        $emailverify->save();

        Mail::to($request->email)->send(new EmailVerify($otp));

        return response()->json([
            'success' => true,
            'message' => 'OTP has been sent to your email!'
        ]);
    }

    public function otp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'email' => 'required|email',
            'name' => 'required',
            'telephone' => 'required',
            'password' => 'required',
        ]);

        $otp = EmailVerification::where('email', $request->email)
            ->where('created_at', '>', Carbon::now()->subMinutes(5))
            ->latest()
            ->first();

        if (!$otp || !Hash::check($request->otp, $otp->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ]);
        }

        $username = User::generateUsername($request->name);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => Hash::make($request->password),
            'username' => $username
        ];
        $user = User::create($userData);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'csrf_token' => csrf_token(),
        ]);
    }
}
