<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistercompanyRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Mail\EmailVerify;
use App\Models\Company;
use App\Models\EmailVerification;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['otpUser', 'registerUser']]);
    }

    public function registerUser(RegisterRequest $request)
    {
        try {
            $userData = $request->validated();

            $username = User::generateUsername($userData['name']);
            $userData['username'] = $username;

            $existingUser = User::where('email', $userData['email'])->first();
            // if ($existingUser && $existingUser->email_verified_at) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Email is not available'
            //     ], 422);
            // }
            if ($existingUser) {
                $existingUser->update($userData);
            } else {
                $company = User::create($userData);
            }

            $otp = random_int(100000, 999999);
            $emailverify = EmailVerification::create([
                'email' => $request->email,
                'token' => Hash::make($otp),
                'created_at' => now(),
            ]);

            Mail::to($request->email)->send(new EmailVerify($otp));

            return response()->json([
                'success' => true,
                'message' => 'OTP has been sent to your email!'
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function otpUser(Request $request)
    {
        try {
            $otp = EmailVerification::where('email', $request->email)
                ->where('created_at', '>', Carbon::now()->subMinutes(5))
                ->latest()
                ->firstOrFail();

            if (!Hash::check($request->otp, $otp->token)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP'
                ], 422);
            }

            $user = User::where('email', $request->email)->first();
            $user->email_verified_at = now();
            $user->save();

            $credentials = ['email' => $request->email, 'password' => $request->password];
            $token = auth()->attempt($credentials);

            return response()->json([
                'success' => true,
                'token' => $token
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email or OTP'
            ], 422);
        }
    }

    public function registerCompany(RegisterRequest $request)
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
    public function otpCompany(Request $request)
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
