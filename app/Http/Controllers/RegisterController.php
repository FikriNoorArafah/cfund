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
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['otp', 'register', 'registercompany', 'otpcompany']]);
    }

    // public function register(RegisterRequest $request)
    // {
    //     $userData = $request->validated([
    //         'name' => 'required|min:4',
    //         'email' => 'required',
    //         'telephone' => 'required',
    //         'password' => 'required|min:8',
    //     ]);

    //     $username = User::generateUsername($userData['name']);
    //     $userData['username'] = $username;
    //     $existingUser = User::where('email', $userData['email'])->first();
    //     if ($existingUser && $existingUser->email_verified_at) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Email is not available'
    //         ], 422);
    //     }

    //     if ($existingUser) {
    //         $existingUser->update($userData);
    //     } else {
    //         $company = User::create($userData);
    //     }

    //     $otp = random_int(100000, 999999);
    //     $emailverify = new EmailVerification();
    //     $emailverify->email = $request->email;
    //     $emailverify->token = Hash::make($otp);
    //     $emailverify->created_at = now();
    //     $emailverify->save();

    //     Mail::to($request->email)->send(new EmailVerify($otp));

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'OTP has been sent to your email!'
    //     ]);
    // }

    // public function otp(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email',
    //         'name' => 'required',
    //         'telephone' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $otp = EmailVerification::where('email', $request->email)
    //         ->where('created_at', '>', Carbon::now()->subMinutes(5))
    //         ->latest()
    //         ->first();


    //     if (!$otp || !Hash::check($request->otp, $otp->token)) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Invalid OTP'
    //         ], 422);
    //     }
    //     $user = User::where('email', $request->email)->first();
    //     $user->email_verified_at = now();
    //     $user->save();

    //     $token = auth()->attempt($credentials);

    //     Auth::login($user);
    //     $token = auth()->attempt($credentials);

    //     return response()->json([
    //         'success' => true,
    //         'token' => $token,
    //     ]);
    // }

    public function register(RegisterRequest $request)
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

            $user = $existingUser ? $existingUser->update($userData) : User::create($userData);

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

    public function otp(Request $request)
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

            $credentials = ['email' => $user->email, 'password' => $request->password];
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

    public function registercompany(RegisterRequest $request)
    {
        try {
            $userData = $request->validated();
            $username = Company::generateUsername($userData['name']);
            $userData['username'] = $username;

            $existingCompany = Company::where('email', $userData['email'])->first();
            if ($existingCompany && $existingCompany->email_verified_at) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email is not available'
                ], 422);
            }

            if ($existingCompany) {
                $existingCompany->update($userData);
            } else {
                $company = Company::create($userData);
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to register',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function otpcompany(Request $request)
    {
        try {
            $credentials = $request->validate([
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

            $company = Company::where('email', $request->email)->first();
            $company->email_verified_at = now();
            $company->save();

            $token = auth()->attempt($credentials);

            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid credentials'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify OTP',
                'error' => $e->getMessage()
            ], 422);
        }
    }
}
