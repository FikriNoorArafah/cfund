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
        $user = Auth::user();
        $intern = Intern::with(['companies', 'majors', 'educations', 'interests', 'levels'])
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
                'level' => $program->levels->pluck('name')->first(),
            ];
        }

        $wts = Whattheysay::select('name', 'position', 'comment')->take(3)->get();

        return response()->json([
            'user' => [
                'name' => $user->name . ' ' . $user->second_name,
                'url_icon' => $user->url_icon
            ],
            'partner' => $partners,
            'katamereka' => $wts,
            'program' => $data,
        ]);
    }
}
