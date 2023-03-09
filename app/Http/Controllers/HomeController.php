<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Intern;
use App\Models\Whattheysay;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::guard('company')->check()) {
            return app('App\Http\Controllers\CompanyController')->index();
        }

        $partners = $this->getPartners();
        $wts = $this->getWhattheysays();
        $intern = $this->getInterns();

        $user = Auth::user() ?? (object) ['name' => 'Guest'];

        if (request()->ajax()) {
            return response()->json([
                'user' => $user,
                'partners' => $partners,
                'whattheysays' => $wts,
                'interns' => $intern,
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
        return Intern::with(['companies', 'majors', 'educations', 'interests'])->get();
    }

    private function getWhattheysays()
    {
        return Whattheysay::all();
    }
}
