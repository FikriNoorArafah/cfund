<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Contracts\Service\Attribute\Required;

class ParticipantController extends Controller
{
    public function index(Request $request)
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
            'totalParticipant' => $totalParticipants,
            'participant' => $participant,
        ]);
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'participant_id' => 'required',
                'schedule' => 'nullable',
                'place' => 'nullable',
                'status' => 'required',
            ]);

            $participant = Participant::find($request->participant_id);
            if (!$participant) {
                throw new \Exception('Participant not found.');
            }

            $participant->schedule = $request->schedule;
            $participant->place = $request->place;
            $participant->status = $request->status;
            $participant->save();

            return response()->json([
                'success' => true,
                'message' => 'berhasil update',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
