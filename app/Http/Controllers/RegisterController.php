<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistercompanyRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Mail\EmailVerify;
use App\Models\Company;
use App\Models\EmailVerification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request->validated([
            'name' => 'required|min:4',
            'email' => 'required',
            'telephone' => 'required',
            'password' => 'required|min:8',
        ]);

        // $emailExist = User::where('email', $request->email)->exists();

        // if ($emailExist) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Email sudah dipakai'
        //     ], 422);
        // }

        // $telephoneExist = User::where('telephone', $request->telephone)->exists();

        // if ($telephoneExist) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Telepon sudah dipakai'
        //     ], 422);
        // }

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
            ], 422);
        }

        $username = User::generateUsername($request->name);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => $request->password,
            'username' => $username
        ];

        $user = User::create($userData);

        Auth::login($user);
        $request->session()->regenerateToken();

        $user->remember_token = csrf_token();
        $user->save();

        $token = csrf_token();
        $request->session()->put('user_csrf_token', $token);

        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function registercompany(RegistercompanyRequest $request)
    {
        $userData = $request->validated();
        $username = Company::generateUsername($userData['name']);
        $userData['username'] = $username;
        $emailExist = Company::where('email', $userData['email'])->exists();

        if ($emailExist) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah dipakai',
            ], 422);
        }

        $telephoneExist = Company::where('telephone', $userData['telephone'])->exists();

        if ($telephoneExist) {
            return response()->json([
                'success' => false,
                'message' => 'Telepon sudah dipakai',
            ], 422);
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
    public function otpcompany(Request $request)
    {
        $request->validate([
            'otp' => 'required',
            'email' => 'required|email',
            'name' => 'required',
            'telephone' => 'required',
            'password' => 'required',
        ]);

        $otp = EmailVerification::where('email', $request->email)
            ->where('created_at', '>', Carbon::now()->subMinutes(2))
            ->latest()
            ->first();

        if (!$otp || !Hash::check($request->otp, $otp->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ], 422);
        }

        $username = Company::generateUsername($request->name);
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'password' => $request->password,
            'username' => $username
        ];
        $companies = Company::create($userData);
        Auth::login($companies);
        $request->session()->regenerateToken();
        $companies->remember_token = csrf_token();
        $companies->save();

        $token = csrf_token();
        $request->session()->put('user_csrf_token', $token);
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }
}
