<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Participant;
use App\Models\Intern;

class HistoryController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $participants = Participant::where('user_id', $user->user_id)->get();
        $intern = Intern::with(['companies', 'majors', 'educations'])->first();

        $history = [];

        foreach ($participants as $participant) {
            $history[] = [
                'cv_url' => $participant->cv_url,
                'schedule' => $participant->schedule,
                'place' => $participant->place,
                'status' => $participant->status,
                'intern' => $intern
            ];
        }
        return response()->json([
            'user' => $user,
            'history' => $history,
        ]);
    }

    public function selection()
    {
        $user = Auth::user();

        $participants = Participant::where('user_id', $user->user_id)
            ->where('status', 'selection')
            ->get();
        $intern = Intern::with(['companies', 'majors', 'educations'])->first();

        $history = [];

        foreach ($participants as $participant) {
            $history[] = [
                'cv_url' => $participant->cv_url,
                'schedule' => $participant->schedule,
                'place' => $participant->place,
                'status' => $participant->status,
                'intern' => $intern
            ];
        }
        return response()->json([
            'user' => $user,
            'history' => $history,
        ]);
    }

    public function accepted()
    {
        $user = Auth::user();

        $participants = Participant::where('user_id', $user->user_id)
            ->where('status', 'accepted')
            ->get();
        $intern = Intern::with(['companies', 'majors', 'educations'])->first();

        $history = [];

        foreach ($participants as $participant) {
            $history[] = [
                'cv_url' => $participant->cv_url,
                'schedule' => $participant->schedule,
                'place' => $participant->place,
                'status' => $participant->status,
                'intern' => $intern
            ];
        }

        return response()->json([
            'user' => $user,
            'history' => $history,
        ]);
    }

    public function rejected()
    {
        $user = Auth::user();

        $participants = Participant::where('user_id', $user->user_id)
            ->where('status', 'rejected')
            ->get();
        $intern = Intern::with(['companies', 'majors', 'educations'])->first();

        $history = [];

        foreach ($participants as $participant) {
            $history[] = [
                'cv_url' => $participant->cv_url,
                'schedule' => $participant->schedule,
                'place' => $participant->place,
                'status' => $participant->status,
                'intern' => $intern
            ];
        }
        return response()->json([
            'user' => [
                'name' => $user->name . ' ' . $user->second_name,
                'url_icon' => $user->url_icon,
                'region' => $user->region,
                'city' => $user->city,
            ],
            'history' => $history,
        ]);
    }

    public function success()
    {
        $user = Auth::user();

        $participants = Participant::where('user_id', $user->user_id)
            ->where('status', 'success')
            ->get();
        $intern = Intern::with(['companies', 'majors', 'educations'])->first();

        $history = [];

        foreach ($participants as $participant) {
            $history[] = [
                'cv_url' => $participant->cv_url,
                'schedule' => $participant->schedule,
                'place' => $participant->place,
                'status' => $participant->status,
                'intern' => $intern
            ];
        }

        return response()->json([
            'user' => $user,
            'history' => $history,
        ]);
    }
}
