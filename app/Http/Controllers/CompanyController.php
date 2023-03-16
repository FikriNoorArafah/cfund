<?php

namespace App\Http\Controllers;

use App\Models\Intern;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Auth::guard('company')->user();

        $interns = Intern::with(['companies', 'majors', 'educations', 'interests', 'levels', 'departments'])
            ->where('interns.company_id', $companies->company_id)
            ->withCount('participants')
            ->get();
        $totalParticipants = $interns->sum('participants_count');

        $internIds = Intern::where('company_id', $companies->company_id)->pluck('intern_id');
        $totalAmount = Semester::whereIn('participant_id', function ($query) use ($internIds) {
            $query->select('participant_id')
                ->from('participants')
                ->whereIn('intern_id', $internIds);
        })
            ->whereNotNull('payment_id')
            ->sum('payment_amount');

        $data = [];
        foreach ($interns as $program) {
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
                'participant' => $program->participants_count,
            ];
        }

        return response()->json([
            'company' => [
                'name' => $companies->name,
                'url_icon' => $companies->url_icon,
                'region' => $companies->region,
                'city' => $companies->city,
            ],
            'totalPayment' => $totalAmount,
            'totalParticipant' => $totalParticipants,
            'program' => $data,
        ]);
    }
}
