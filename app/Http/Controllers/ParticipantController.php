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
        $participants = Participant::with('majors')
            ->whereHas('interns', function ($query) use ($companies) {
                $query->where('company_id', $companies->company_id);
            })
            ->where('status', 'selection')
            ->get(['participant_id', 'user_id', 'schedule', 'place', 'status']);

        return response()->json(['participant' => $participants]);
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
