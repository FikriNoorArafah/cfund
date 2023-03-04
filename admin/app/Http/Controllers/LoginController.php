<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request){
            $credentials = $request->getCredentials();

            if(!Auth::validate($credentials)):
                return redirect()->to('login')
                    ->withErrors(trans('auth.failed'));
            endif;

            $admin = Auth::getProvider()->retrieveByCredentials($credentials);

            Auth::login($admin);

            return $this->authenticated($request, $admin);
        }

        protected function authenticated(request $request, $admin){
            return redirect()->intended();
        }
}
