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

    public function participate(Request $request)
    {
        $intern = $this->getInterns();
        $user = Auth::user();

        $request->validate([
            'intern_id' => 'required',
            'cv_url' => 'required| (bentuk text)',
        ]);

        $participant = new Participant();
        $participant->intern_id = $request->intern_id;
        $participant->user_id = $user->user_id;
        $participant->cv_url = $request->cv_url;
        $participant->save();

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Berhasil daftar intern',
                'user' => $user,
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
