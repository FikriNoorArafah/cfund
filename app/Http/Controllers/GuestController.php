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

        $intern = Intern::with(['companies', 'majors', 'educations', 'interests', 'levels', 'departments'])
            ->take(7)
            ->get();

        $data = [];
        foreach ($intern as $program) {
            $data[] = [
                'title' => $program->majors->pluck('name')->first(),
                'url' => $program->companies->url_icon,
                'company' => $program->companies->name,
                'region' => $program->companies->region,
                'city' => $program->companies->city,
                'kategori' => $program->interests->pluck('name')->first(),
                'education' => $program->educations->pluck('name'),
                'department' => $program->departments->pluck('name')->first(),
                'level' => $program->levels->pluck('name')->first(),
            ];
        }

        $wts = Whattheysay::select('name', 'position', 'comment')->take(3)->get();

        return response()->json([
            'partner' => $partners,
            'katamereka' => $wts,
            'program' => $data,
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
