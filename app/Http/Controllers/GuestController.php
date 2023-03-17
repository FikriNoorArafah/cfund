<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Company;
use App\Models\Help;
use App\Models\Intern;
use App\Models\Participant;
use App\Models\Partner;
use App\Models\User;
use App\Models\Whattheysay;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function landing()
    {
        $partners = Partner::select('name', 'url_icon')->take(8)->get();

        $interns = Intern::with(['companies', 'majors', 'educations', 'levels'])
            ->take(7)
            ->get()
            ->map(function ($intern) {
                return [
                    'id' => $intern->intern_id,
                    'title' => $intern->majors->pluck('name')->implode(', '),
                    'url' => $intern->companies->url_icon,
                    'company' => $intern->companies->name,
                    'region' => $intern->companies->region,
                    'city' => $intern->companies->city,
                    'education' => $intern->educations->pluck('name'),
                    'level' => $intern->levels->pluck('name')->implode(', '),
                ];
            });

        $wts = Whattheysay::select('wts_id', 'name', 'position', 'quote')->take(3)->get();

        return response()->json([
            'partner' => $partners,
            'katamereka' => $wts,
            'program' => $interns,
        ]);
    }

    public function help()
    {
        $helps = Help::select('question', 'answer')->take(5)->get();
        return response()->json(['helps' => $helps,]);
    }

    public function about()
    {
        $abouts = About::select('title', 'subtitle')->first();
        $user = User::count();
        $company = Company::count();
        $participant = Participant::distinct('user_id')->count('user_id');
        return response()->json([
            'Abouts' => $abouts,
            'usercount' => $user,
            'companycount' => $company,
            'participate' => $participant,
        ]);
    }

    public function welcome()
    {
        return view('welcome');
    }
}
