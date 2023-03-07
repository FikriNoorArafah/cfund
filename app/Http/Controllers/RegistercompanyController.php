<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\RegistercompanyRequest;

class RegistercompanyController extends Controller
{
    public function show()
    {
        return view('company.register');
    }

    public function register(RegistercompanyRequest $request)
    {
        $userData = $request->validated();
        $username = Company::generateUsername($userData['name']);
        $userData['username'] = $username;
        $company = Company::create($userData);
        auth()->login($company);
        return redirect('/company')->with('success', "Akun berhasil dibuat");
    }
}
