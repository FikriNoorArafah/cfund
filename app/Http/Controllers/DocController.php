<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocController extends Controller
{
    public function index()
    {
        $url = '';
        return redirect()->away($url);
    }
}
