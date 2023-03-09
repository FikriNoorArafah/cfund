<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocController extends Controller
{
    public function index()
    {
    $file_path = resource_path('views/docs.txt');
        return response()->file($file_path, [
            'Content-Type' => 'text/plain'
        ]);
    }
}
