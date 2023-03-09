<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Intern;
use App\Models\Whattheysay;

class HomeController extends Controller
{
    public function index()
    {
        $partners = $this->getPartners();
        $wts = $this->getWhattheysays();
        $intern = $this->getInterns();

        if (request()->ajax()) {
            return response()->json([
                'partners' => $partners,
                'whattheysays' => $wts,
                'interns' => $intern
            ]);
        }

        return view('user.index', compact('partners', 'wts', 'intern'));
    }

    private function getPartners()
    {
        return Partner::all();
    }

    private function getInterns()
    {
        return Intern::with(['majors', 'educations', 'interests'])->get();
    }

    private function getWhattheysays()
    {
        return Whattheysay::all();
    }
}
