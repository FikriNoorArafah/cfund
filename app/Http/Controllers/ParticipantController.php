<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Contracts\Service\Attribute\Required;

class ParticipantController extends Controller
{
    public function index()
    {
        $companies = Auth::guard('company')->user();
        $participant = $participants = Participant::join('interns', 'interns.intern_id', '=', 'participants.intern_id')
            ->join('users', 'users.user_id', '=', 'participants.user_id')
            ->where('interns.company_id', '=', $companies->company_id)
            ->where('participants.status', 'selection')
            ->select('users.name', 'users.second_name', 'participants.*')
            ->get();
        $totalParticipants = $participant->count();
        return response()([
            'company' => $companies,
            'totalParticipant' => $totalParticipants,
            'participant' => $participant,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|integer',
            'schedule' => 'nullable|string|max:255',
            'place' => 'nullable|string|max:255',
        ]);

        $participant = Participant::find($request->participant_id);
        if (!$participant) {
            return response()([
                'success' => false,
            ]);
        }

        $participant->schedule = $request->schedule;
        $participant->place = $request->place;
        $participant->save();

        return response()([
            'success' => true,
        ]);
    }
}
