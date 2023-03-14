<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Help;

class HelpController extends Controller
{
    public function index()
    {
        $helps = Help::select('question', 'answer')->take(5)->get();
        return response()->json(['helps' => $helps,]);
    }

    public function user()
    {
        $helps = Help::select('question', 'answer')->take(5)->get();
        $user = Auth::user();
        return response()->json([
            'user' => [
                'name' => $user->name . ' ' . $user->second_name,
                'url_icon' => $user->url_icon
            ],
            'helps' => $helps,
        ]);
    }
}
