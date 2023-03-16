<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->getCredentials();

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $request->session()->regenerateToken();

                $user->remember_token = csrf_token();
                $user->save();

                $token = csrf_token();
                $request->session()->put('user_csrf_token', $token);

                return response()->json([
                    'success' => true,
                    'token' => $token,
                ]);
            } else {
                throw new \Exception(trans('auth.failed'));
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }


    public function company(LoginRequest $request)
    {
        try {
            $credentials = $request->getCredentials();

            if (auth()->guard('company')->attempt($credentials)) {
                $companies = auth()->guard('company')->user();
                $request->session()->regenerateToken();
                $companies->remember_token = csrf_token();
                $companies->save();

                $token = csrf_token();
                $request->session()->put('user_csrf_token', $token);
                return response()->json([
                    'success' => true,
                    'token' => $token,
                ]);
            } else {
                throw new \Exception(trans('auth.failed'));
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
}
