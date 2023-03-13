<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Partner;
use App\Models\Whattheysay;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $partners = Partner::all()->take(8);
        // $intern = Intern::join('companies', 'interns.company_id', '=', 'companies.company_id')
        //     ->join('intern_majors', 'interns.intern_id', '=', 'intern_majors.intern_id')
        //     ->join('majors', 'intern_majors.major_id', '=', 'majors.major_id')
        //     ->leftJoin('intern_educations', 'interns.intern_id', '=', 'intern_educations.intern_id')
        //     ->leftJoin('educations', 'intern_educations.education_id', '=', 'educations.education_id')
        //     ->select('interns.intern_id', 'companies.name as company', 'majors.name as major', 'educations.name as education', 'companies.region', 'companies.city', 'companies.url_icon')
        //     ->take(7)
        //     ->get();

        $intern = Intern::with([
            'companies' => function ($query) {
                return $query->select('company_id', 'name', 'region', 'city', 'url_icon');
            }, 'majors', 'educations', 'interests', 'levels'
        ])
            ->take(7)
            ->get();


        $wts = Whattheysay::all()->take(3);

        if (request()) {
            return response()->json([
                'partner' => $partners,
                'whattheysay' => $wts,
                'intern' => $intern,
            ]);
        }

        return view('welcome', compact('partners', 'intern', 'wts'));
    }
}
