<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Intern;
use App\Models\Participant;

class ProgramController extends Controller
{
    public function index()
    {
        $intern = $this->getInterns();

        $user = Auth::user();

        $hasSelectionOrAccepted = Participant::where('user_id', $user->user_id)
            ->where(function ($query) {
                $query->where('status', 'selection')
                    ->orWhere('status', 'accepted');
            })
            ->exists();

        $regist = $hasSelectionOrAccepted ? 'disable' : 'enable';

        if (request()->ajax()) {
            return response()->json([
                'user' => $user,
                'regist' => $regist,
                'interns' => $intern,
            ]);
        }

        return view('user.program', compact('user', 'intern', 'regist'));
    }

    private function getInterns()
    {
        return Intern::with(['companies', 'majors', 'educations', 'interests'])->get();
    }
}
