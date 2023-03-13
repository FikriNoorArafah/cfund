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
        $intern = Intern::with([
            'companies' => function ($query) {
                return $query->select('company_id', 'name', 'region', 'city', 'url_icon');
            }, 'majors', 'educations', 'interests', 'levels'
        ])
            ->take(7)
            ->get();
        $wts = Whattheysay::select('name', 'position', 'comment')->take(3);

        $user = Auth::user();

        return response()([
            'user' => [
                'name' => $user->name . ' ' . $user->second_name,
                'url_icon' => $user->url_icon
            ],
            'partner' => $partners,
            'katamereka' => $wts,
            'program' => $intern,
        ]);
    }
}
