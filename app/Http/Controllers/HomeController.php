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

        $user = session('user');
        if ($user) {
            $userData = $user;
        } else {
            $userData = [];
        }

        if (request()->ajax()) {
            return response()->json([
                'user' => $userData,
                'partners' => $partners,
                'whattheysays' => $wts,
                'interns' => $intern,
            ]);
        }

        return view('user.index', compact('partners', 'wts', 'intern', 'userData'));
    }

    private function getPartners()
    {
        return Partner::all();
    }

    private function getInterns()
    {
        return Intern::with(['majors', 'educations', 'interests', 'companies'])->get();
    }

    private function getWhattheysays()
    {
        return Whattheysay::all();
    }
}
