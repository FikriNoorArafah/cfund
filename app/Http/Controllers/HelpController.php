<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Help;

class HelpController extends Controller
{
    public function index()
    {
        $helps = Help::all()->take(5);
        return response()(['helps' => $helps,]);
    }

    public function user()
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
