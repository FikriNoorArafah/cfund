<?php

namespace App\Http\Controllers;

use App\Models\Help;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHelpController extends Controller
{
    public function index()
    {
        $helps = Help::all();
        $user = Auth::user();
        return response()([
            'user' => [
                'name' => $user->name . ' ' . $user->second_name,
                'url_icon' => $user->url_icon
            ],
            'helps' => $helps,
        ]);
    }
}
