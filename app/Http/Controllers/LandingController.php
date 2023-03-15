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
    public function welcome()
    {
        return view('welcome');
    }
}
