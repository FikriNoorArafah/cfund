<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['loginUser', 'loginCompany']]);
    }
    public function loginUser(LoginRequest $request)
    {
        try {
            $credentials = $request->getCredentials();
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = auth()->attempt($credentials);
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

    public function loginCompany(LoginRequest $request)
    {
        try {
            $credentials = $request->getCredentials();
            if (auth()->guard('company')->attempt($credentials)) {
                $companies = auth()->guard('company')->user();
                $request->session()->regenerateToken();
                $token = auth()->guard('company')->attempt($credentials);
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
