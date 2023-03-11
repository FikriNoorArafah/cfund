<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Contracts\Service\Attribute\Required;

class FinancingController extends Controller
{
    public function index()
    {
        $companies = Auth::guard('company')->user();
        $participant = $this->getParticipant($companies->company_id);
        $totalParticipants = $participant->count();

        if (request()->ajax()) {
            return response()->json([
                'company' => $companies,
                'totalParticipant' => $totalParticipants,
                'participant' => $participant,
            ]);
        }

        return view('company.financing', compact('participant', 'companies', 'totalParticipants'));
    }


    public function getParticipant($companyId)
    {
        $participants = Participant::join('interns', 'interns.intern_id', '=', 'participants.intern_id')
            ->join('users', 'users.user_id', '=', 'participants.user_id')
            ->where('interns.company_id', '=', $companyId)
            ->where('participants.status', 'accepted')
            ->select('users.name', 'users.second_name', 'participants.*')
            ->get();
        return $participants;
    }

    // public function update(Request $request)
    // {
    //     $request->validate([
    //         'participant_id' => 'required|integer',
    //         'schedule' => 'nullable|string|max:255',
    //         'place' => 'nullable|string|max:255',
    //     ]);

    //     $participant = Participant::find($request->participant_id);
    //     if (!$participant) {
    //         return response()->json([
    //             'success' => false,
    //         ]);
    //     }

    //     $participant->schedule = $request->schedule;
    //     $participant->place = $request->place;
    //     $participant->save();

    //     return response()->json([
    //         'success' => true,
    //         'participant' => $participant,
    //     ]);
    // }
}
