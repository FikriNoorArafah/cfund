<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LogincompanyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Log;

class LogincompanyController extends Controller
{
    // public function login(LogincompanyRequest $request)
    // {
    //     $credentials = $request->getCredentials();

    //     if (auth()->guard('company')->attempt($credentials)) {
    //         $company = auth()->guard('company')->user();
    //         return response()->json([
    //             'success' => true,
    //             'csrf_token' => csrf_token()
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => trans('auth.failed')
    //         ], 422);
    //     }
    // }

    public function login(LogincompanyRequest $request)
    {
        try {
            $credentials = $request->getCredentials();

            if (auth()->guard('company')->attempt($credentials)) {
                $company = auth()->guard('company')->user();
                return response()->json([
                    'success' => true,
                    'csrf_token' => csrf_token()
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
