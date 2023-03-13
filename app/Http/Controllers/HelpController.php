<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Help;

class HelpController extends Controller
{
    public function index()
    {
        $helps = Help::all();
        return response()->json(['helps' => $helps,]);
    }
}
