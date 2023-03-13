<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\RegistercompanyRequest;

class RegistercompanyController extends Controller
{

    public function register(RegistercompanyRequest $request)
    {
        $userData = $request->validated();
        $username = Company::generateUsername($userData['name']);
        $userData['username'] = $username;
        $company = Company::create($userData);
        auth()->guard('company')->login($company);
        return response()([
            'csrf_token' => csrf_token(),
        ]);
    }
}
