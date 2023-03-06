<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class HomeController extends Controller
{
    public function index()
    {
        $partners = $this->getPartners();
        return view('user.index', compact('partners'));
    }

    private function getPartners()
    {
        return Partner::all();
    }
}
