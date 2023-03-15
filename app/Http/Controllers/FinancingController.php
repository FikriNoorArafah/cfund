<?php


namespace App\Http\Controllers;


use App\Models\Participant;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;
use Midtrans\Config;
use Midtrans\Snap;

class FinancingController extends Controller
{
    public function index()
    {
        $companies = Auth::guard('company')->user();
        $participant = Participant::join('interns', 'interns.intern_id', '=', 'participants.intern_id')
            ->join('users', 'users.user_id', '=', 'participants.user_id')
            ->where('interns.company_id', '=', $companies->company_id)
            ->where('participants.status', 'accepted')
            ->select('users.name', 'users.second_name', 'participants.*')
            ->get();
        $totalParticipants = $participant->count();

        return response()->json([
            'company' => $companies,
            'totalParticipant' => $totalParticipants,
            'participant' => $participant,
        ]);
    }


    public function detail(Request $request)
    {
        $request->validate([
            'participant_id' => 'required|integer',
        ]);

        $companies = Auth::guard('company')->user();

        $participant = Participant::with(['users:user_id,name,second_name', 'semesters.tasks'])
            ->where('participants.status', 'accepted')
            ->where('participants.participant_id', $request->participant_id)
            ->first();


        return response()->json([
            'company' => $companies,
            'participant' => $participant,
        ]);
    }


    public function payment(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|integer',
            'payment_amount' => 'required|integer'
        ]);

        $semester = Semester::findOrFail($request->semester_id);

        if ($semester->payment_id) {
            return response()->json([
                'success' => false,
                'message' => 'Uang sudah pernah dikirimkan',
            ]);
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config(('midtrans.is_3ds'));

        $details = [
            'transaction_details' => [
                'order_id' => 'ORDER-ID-' . time(),
                'gross_amount' => intval($request->payment_amount),
                'currency' => 'IDR',
            ],

        ];

        $snapToken = Snap::getSnapToken($details);

        $semester->payment_amount = $request->payment_amount;
        $semester->save();

        // $paymentUrl = Snap::createTransactionUrl($snapToken);

        return response()->json([
            'success' => true,
            'message' => 'Payment URL generated successfully',
            'snaptoken' => $snapToken,
            // 'url' => $paymentUrl
        ]);
    }



    public function handlePaymentNotification(Request $request)
    {
        $request->validate([
            'transaction_status' => 'required|string',
            'order_id' => 'required|string',
            'gross_amount' => 'required|numeric',
        ]);

        $transactionStatus = $request->transaction_status;
        $orderId = $request->order_id;
        $grossAmount = $request->gross_amount;

        // Midtrans API call to get transaction details
        // ...

        $semester = Semester::where('payment_id', $orderId)->first();

        if (!$semester) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid payment ID',
            ]);
        }

        if ($semester->payment_amount != $grossAmount) {
            return response()->json([
                'success' => false,
                'message' => 'Payment amount does not match',
            ]);
        }

        if ($transactionStatus == 'capture') {
            $semester->payment_id = $orderId;
            $semester->save();

            return response()->json([
                'success' => true,
                'message' => 'Payment successful',
                'semester' => $semester,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Payment unsuccessful',
            ]);
        }
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
