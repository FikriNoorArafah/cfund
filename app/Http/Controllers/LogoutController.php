<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $user = Auth::user();

        $user->remember_token = null;
        $user->save();

        Session::flush();
        Auth::logout();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    public function company()
    {
        $companies = Auth::guard('company')->user();
        $companies->remember_token = null;
        $companies->save();

        Session::flush();
        Auth::logout();

        return response()->json([
            'succes' => true,
            'message' => 'berhasil logout',
        ]);
    }
}
