<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)) :
            return response()([
                'csrf_token' => trans('auth.failed')
            ]);
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    protected function authenticated(request $request, $user)
    {
        return response()([
            'csrf_token' => csrf_token()
        ]);
    }
}
