<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $userData = $request->validated();
        $username = User::generateUsername($userData['name']);
        $userData['username'] = $username;
        $user = User::create($userData);
        auth()->login($user);
        return response()->json([
            'csrf_token' => csrf_token(),
            'message' => 'akun berhasil dibuat',
        ]);
    }
}
