<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LogincompanyRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Log;

class LogincompanyController extends Controller
{
    public function login(LogincompanyRequest $request)
    {
        $credentials = $request->getCredentials();

        if (auth()->guard('company')->attempt($credentials)) {
            $company = auth()->guard('company')->user();
            return response()([
                'message' => 'anda berhasil login',
                'csrf_token' => csrf_token()
            ]);
        } else {
            return response()([
                'message' => trans('auth.failed')
            ]);
        }
    }


    // public function login(LogincompanyRequest $request)
    // {
    //     try {
    //         $credentials = $request->getCredentials();

    //         if (!$this->guard()->validate($credentials)) {
    //             throw new \Exception(trans('auth.failed'));
    //         }

    //         $company = $this->guard()->getProvider()->retrieveByCredentials($credentials);

    //         if (!$company) {
    //             throw new \Exception(trans('auth.failed'));
    //         }

    //         $this->guard()->login($company);

    //         return $this->authenticated($request, $company);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'message' => $e->getMessage()
    //         ]);
    //     }
    // }
}
