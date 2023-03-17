<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Intern;
use App\Models\Participant;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProgramController extends Controller
{
    public function program()
    {
        $intern = Intern::join('companies', 'interns.company_id', '=', 'companies.company_id')
            ->join('intern_majors', 'interns.intern_id', '=', 'intern_majors.intern_id')
            ->join('majors', 'intern_majors.major_id', '=', 'majors.major_id')
            ->leftJoin('intern_educations', 'interns.intern_id', '=', 'intern_educations.intern_id')
            ->leftJoin('educations', 'intern_educations.education_id', '=', 'educations.education_id')
            ->select('interns.intern_id', 'companies.name as company', 'majors.name as major', 'educations.name as education', 'companies.region', 'companies.city', 'companies.url_icon')
            ->take(7)
            ->get();

        $user = Auth::user();

        $hasSelectionOrAccepted = Participant::where('user_id', $user->user_id)
            ->where(function ($query) {
                $query->where('status', 'selection')
                    ->orWhere('status', 'accepted');
            })
            ->exists();

        $regist = $hasSelectionOrAccepted ? 'disable' : 'enable';

        return response()->json([
            'user' => $user,
            'regist' => $regist,
            'interns' => $intern,
        ]);
    }

    public function participate(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'intern_id' => 'required',
            'cv' => 'required|mimes:pdf|max:2048',
        ]);

        $cv = $request->file('cv');
        $result = Cloudinary::upload($cv->getPathname(), [
            'resource_type' => 'raw',
            'folder' => 'careerfund/cv',
            'public_id' => uniqid(),
        ]);

        $participant = new Participant();
        $participant->intern_id = $request->intern_id;
        $participant->user_id = $user->user_id;
        $participant->cv_url = $result->getSecurePath();
        $participant->save();

        return response()->json([
            'message' => 'Berhasil daftar intern',
        ]);
    }
}
