<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Models\Intern;
use App\Models\Participant;
use App\Models\Partner;
use App\Models\Semester;
use App\Models\User;
use App\Models\UserPayment;
use App\Models\Whattheysay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function home(Request $request)
    {
        $partners = Partner::select('name', 'url_icon')->take(8)->get();
        $user = Auth::user();
        $interns = Intern::with(['companies', 'majors', 'educations', 'levels'])
            ->take(7)
            ->get()
            ->map(function ($intern) {
                return [
                    'id' => $intern->intern_id,
                    'title' => $intern->majors->pluck('name'),
                    'url' => $intern->companies->url_icon,
                    'company' => $intern->companies->name,
                    'region' => $intern->companies->region,
                    'city' => $intern->companies->city,
                    'education' => $intern->educations->pluck('name'),
                    'level' => $intern->levels->pluck('name'),
                ];
            });

        $wts = Whattheysay::select('name', 'position', 'quote')->take(4)->get();

        return response()->json([
            'partner' => $partners,
            'katamereka' => $wts,
            'program' => $interns,
        ]);
    }

    public function help(Request $request)
    {
        $helps = Help::select('question', 'answer')->take(5)->get();
        $user = Auth::user();
        return response()->json([
            'helps' => $helps,
        ]);
    }

    public function program()
    {
        $interns = Intern::with(['companies', 'majors', 'educations', 'levels'])
            ->get()
            ->map(function ($intern) {
                return [
                    'id' => $intern->intern_id,
                    'desc' => $intern->description,
                    'skill' => $intern->skill,
                    'require' => $intern->require,
                    'title' => $intern->majors->pluck('name'),
                    'url' => $intern->companies->url_icon,
                    'company' => $intern->companies->name,
                    'region' => $intern->companies->region,
                    'city' => $intern->companies->city,
                    'education' => $intern->educations->pluck('name'),
                    'level' => $intern->levels->pluck('name'),
                ];
            });

        $user = Auth::user();
        $hasSelectionOrAccepted = Participant::where('user_id', $user->user_id)
            ->whereIn('status', ['selection', 'accepted'])
            ->exists();

        $user = Auth::user();

        $user = Auth::user();

        $user_payment = UserPayment::where('user_id', $user->id)->first();

        $lengkap = (!$user->region || !$user->city || !$user->postal || !$user->education || !$user_payment || !$user_payment->type || !$user_payment->credit_number);

        $regist = $hasSelectionOrAccepted ? false : true;

        return response()->json([
            'regist' => $regist,
            'identity' => $lengkap,
            'interns' => $interns,
        ]);
    }

    public function history()
    {
        $user = Auth::user();

        $participants = Participant::where('user_id', $user->user_id)->get();
        $history = [];

        foreach ($participants as $participant) {
            $intern = Intern::with(['companies', 'majors', 'educations'])
                ->where('interns.intern_id', $participant->intern_id)
                ->first();

            $history[] = [
                'status' => $participant->status,
                'deskripsi' => $intern->description,
                'title' => $intern->majors->pluck('name')->first(),
                'url' => $intern->companies->url_icon,
                'company' => $intern->companies->name,
                'region' => $intern->companies->region,
                'city' => $intern->companies->city,
                'education' => $intern->educations->pluck('name'),
            ];
        }

        return response()->json([
            'history' => $history,
        ]);
    }

    public function historySelection()
    {
        $user = Auth::user();

        $participants = Participant::where('user_id', $user->user_id)
            ->where('status', 'selection')
            ->get();
        $history = [];

        foreach ($participants as $participant) {
            $intern = Intern::with(['companies', 'majors', 'educations', 'levels'])
                ->where('interns.intern_id', $participant->intern_id)
                ->first();

            $history[] = [
                'schedule' => $participant->schedule,
                'place' => $participant->place,
                'status' => $participant->status,
                'deskripsi' => $intern->description,
                'title' => $intern->majors->pluck('name')->first(),
                'url' => $intern->companies->url_icon,
                'company' => $intern->companies->name,
                'region' => $intern->companies->region,
                'city' => $intern->companies->city,
                'education' => $intern->educations->pluck('name'),
            ];
        }

        return response()->json([
            'history' => $history,
        ]);
    }

    public function historyAccepted()
    {
        $user = Auth::user();

        $participants = Participant::where('user_id', $user->user_id)
            ->where('status', 'accepted')
            ->get();
        $history = [];

        foreach ($participants as $participant) {
            $intern = Intern::with(['companies', 'majors', 'educations', 'levels'])
                ->where('interns.intern_id', $participant->intern_id)
                ->first();

            $history[] = [
                'status' => $participant->status,
                'deskripsi' => $intern->description,
                'title' => $intern->majors->pluck('name')->first(),
                'url' => $intern->companies->url_icon,
                'company' => $intern->companies->name,
                'region' => $intern->companies->region,
                'city' => $intern->companies->city,
                'education' => $intern->educations->pluck('name'),
            ];
        }

        return response()->json([
            'history' => $history,
        ]);
    }

    public function historyRejected()
    {
        $user = Auth::user();

        $participants = Participant::where('user_id', $user->user_id)
            ->where('status', 'rejected')
            ->get();
        $history = [];

        foreach ($participants as $participant) {
            $intern = Intern::with(['companies', 'majors', 'educations', 'levels'])
                ->where('interns.intern_id', $participant->intern_id)
                ->first();

            $history[] = [
                'status' => $participant->status,
                'deskripsi' => $intern->description,
                'title' => $intern->majors->pluck('name')->first(),
                'url' => $intern->companies->url_icon,
                'company' => $intern->companies->name,
                'region' => $intern->companies->region,
                'city' => $intern->companies->city,
                'education' => $intern->educations->pluck('name'),
            ];
        }

        return response()->json([
            'history' => $history,
        ]);
    }

    public function historySuccess()
    {
        $user = Auth::user();

        $participants = Participant::where('user_id', $user->user_id)
            ->where(function ($query) {
                $query->where('status', 'accepted')
                    ->orWhere('status', 'success');
            })
            ->get();
        $history = [];

        foreach ($participants as $participant) {
            $intern = Intern::with(['companies', 'majors'])
                ->where('interns.intern_id', $participant->intern_id)
                ->first();

            $semesters = $participant->semesters()->with(['tasks'])->get();
            $semesterData = [];

            foreach ($semesters as $semester) {
                $tasksData = [];
                foreach ($semester->tasks as $task) {
                    $tasksData[] = [
                        'name' => $task->name,
                        'summary' => $task->summary_url,
                    ];
                }

                $semesterData[] = [
                    'semester' => $semester->semester_number,
                    'tasks' => $tasksData,
                ];
            }

            $history[] = [
                'participant_id' => $participant->participant_id,
                'status' => $participant->status,
                'deskripsi' => $intern->description,
                'title' => $intern->majors->pluck('name')->first(),
                'url' => $intern->companies->url_icon,
                'company' => $intern->companies->name,
                'region' => $intern->companies->region,
                'city' => $intern->companies->city,
                'education' => $intern->educations->pluck('name'),
                'semesters' => $semesterData,
            ];
        }

        return response()->json([
            'history' => $history,
        ]);
    }

    public function profile(Request $request)
    {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
        ]);
    }
}
