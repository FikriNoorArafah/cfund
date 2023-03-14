<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Company;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
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
}
