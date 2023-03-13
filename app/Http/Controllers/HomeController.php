<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;
use App\Models\Intern;
use App\Models\User;
use App\Models\Whattheysay;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $partners = Partner::select('name', 'url_icon')->take(8)->get();
        $intern = Intern::join('companies', 'interns.company_id', '=', 'companies.company_id')
            ->join('intern_majors', 'interns.intern_id', '=', 'intern_majors.intern_id')
            ->join('majors', 'intern_majors.major_id', '=', 'majors.major_id')
            ->leftJoin('intern_educations', 'interns.intern_id', '=', 'intern_educations.intern_id')
            ->leftJoin('educations', 'intern_educations.education_id', '=', 'educations.education_id')
            ->select('interns.intern_id', 'companies.name as company', 'majors.name as major', 'educations.name as education', 'companies.region', 'companies.city', 'companies.url_icon')
            ->take(7)
            ->get();
        $wts = Whattheysay::all()->take(3);

        $user = Auth::user();

        return response()([
            'user' => [
                'name' => $user->name . ' ' . $user->second_name,
                'url_icon' => $user->url_icon
            ],
            'partners' => $partners,
            'whattheysays' => $wts,
            'interns' => $intern,
        ]);
    }
}
