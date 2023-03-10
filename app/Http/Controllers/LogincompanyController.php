<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LogincompanyRequest;
use Illuminate\Support\Facades\Auth;


class LogincompanyController extends Controller
{
    public function show()
    {
        return view('company.login');
    }

    protected function guard()
    {
        return auth()->guard('company');
    }

    public function login(LogincompanyRequest $request)
    {
        $credentials = $request->getCredentials();

        if (!$this->guard()->validate($credentials)) {
            return redirect()->to('company/login')
                ->withErrors(trans('auth.failed'));
        }
        $company = $this->guard()::getProvider()->retrieveByCredentials($credentials);

        $this->guard()->login($company);

        return $this->authenticated($request, $company);
    }

    protected function authenticated(request $request, $company)
    {
        return redirect('/company')->with('success', "Anda berhasil login");
    }
}
