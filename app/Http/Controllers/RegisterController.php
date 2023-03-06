<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $username = uniqid();
        $userData = $request->validated();
        $userData['username'] = $username;
        $user = User::create($userData);
        auth()->login($user);
        return redirect('/')->with('success', "Akun berhasil dibuat");
    }
}
