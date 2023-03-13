<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Auth::guard('company')->user();
        $interns = Intern::with(['companies', 'majors', 'educations', 'interests'])
            ->select('interns.intern_id', 'companies.name as company', 'majors.name as major', 'educations.name as education', 'companies.region', 'companies.city', 'companies.url_icon')
            ->withCount('participants')
            ->get();
        $totalParticipants = 0;
        foreach ($interns as $intern) {
            $totalParticipants += $intern->participants_count;
        }

        return response()([
            'company' => $companies,
            'totalParticipant' => $totalParticipants,
            'interns' => $interns,
        ]);
    }
}
