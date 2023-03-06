<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Whattheysay;

class HomeController extends Controller
{
    public function index()
    {
        $partners = $this->getPartners();
        $wts = $this->getWhattheysays();
        return view('user.index', compact('partners', 'wts'));
    }

    private function getPartners()
    {
        return Partner::all();
    }

    private function getWhattheysays()
    {
        return Whattheysay::all();
    }
}
