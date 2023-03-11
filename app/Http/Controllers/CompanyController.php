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
        $interns = $this->getInterns();
        $totalParticipants = 0;
        foreach ($interns as $intern) {
            $totalParticipants += $intern->participants_count;
        }

        if (request()->ajax()) {
            return response()->json([
                'company' => $companies,
                'totalParticipant' => $totalParticipants,
                'interns' => $interns,
            ]);
        }

        return view('company.index', compact('interns', 'companies', 'totalParticipants'));
    }

    private function getInterns()
    {
        return Intern::with(['companies', 'majors', 'educations', 'interests'])
            ->withCount('participants')
            ->get();
    }
}
