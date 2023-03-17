<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function user(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();

        Session::flush();
        Auth::logout();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    public function company(Request $request)
    {
        $companies = Auth::guard('company')->user();
        $companies->tokens()->delete();
        Session::flush();
        Auth::logout();

        return response()->json([
            'succes' => true,
            'message' => 'berhasil logout',
        ]);
    }
}
