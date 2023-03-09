<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Help;

class HelpController extends Controller
{
    public function index()
    {
        $helps = $this->getHelps();

        $user = Auth::user() ?? (object) ['name' => 'Guest'];

        if (request()->ajax()) {
            return response()->json([
                'user' => $user,
                'helps' => $helps,
            ]);
        }

        return view('user.help', compact('helps', 'user'));
    }

    private function getHelps()
    {
        return Help::all();
    }
}
