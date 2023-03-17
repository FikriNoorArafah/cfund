<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Task;
use App\Models\UserPayment;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserActionController extends Controller
{
    public function participate(Request $request)
    {
        try {
            $user = Auth::user();

            $request->validate([
                'user_id' => 'required',
                'intern_id' => 'required',
                'cv' => 'required|mimes:pdf|max:2048',
            ]);

            $result = Cloudinary::upload($request->file('cv')->getPathname(), [
                'folder' => 'careerfund/cv',
                'public_id' => 'cv' . uniqid(),
            ]);

            $participant = new Participant();
            $participant->intern_id = $request->intern_id;
            $participant->user_id = $request->user_id;
            $participant->cv_url = $result->getSecurePath();
            $participant->status = 'selection';
            $participant->save();

            return response()->json([
                'success' => true,
                'message' => 'berhasil daftar program',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadContract(Request $request)
    {
        try {
            $user = Auth::user();

            $request->validate([
                'participant_id' => 'required',
                'contract' => 'required|mimes:pdf|max:2048',
            ]);

            $result = Cloudinary::upload($request->file('contract')->getPathname(), [
                'folder' => 'careerfund/contract',
                'public_id' => 'contract' . uniqid(),
            ]);

            $participant = Participant::findOrFail($request->participant_id);
            $participant->contract_url = $result->getSecurePath();
            $participant->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil upload kontrak',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadSummary(Request $request)
    {
        try {
            $user = Auth::user();

            $request->validate([
                'task_id' => 'required',
                'summary' => 'required|mimes:pdf|max:2048',
            ]);

            $result = Cloudinary::upload($request->file('contract')->getPathname(), [
                'folder' => 'careerfund/summary',
                'public_id' => 'summary' . uniqid(),
            ]);

            $task = Task::findOrFail($request->task_id);
            $task->summary_url = $result->getSecurePath();
            $task->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil upload kontrak',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function paymentMethod(Request $request)
    {
        $user = Auth::user();
        try {
            $request->validate([
                'type' => 'required',
                'credit' => 'required'
            ]);

            $userPayment = UserPayment::updateOrCreate(
                ['user_id' => $user->user_id],
                ['type' => $request->type, 'credit_number' => $request->credit]
            );
            return response()->json([
                'success' => true,
                'message' => 'berhasil menyimpan data pembayaran',
                'data' => $userPayment
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        try {
            $request->validate([
                'name' => 'required',
                'second_name' => 'nullable',
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($user),
                ],
                'telephone' => [
                    'required',
                    Rule::unique('users')->ignore($user),
                ],
                'region' => 'nullable',
                'city' => 'nullable',
                'postal' => 'nullable',
                'education' => 'nullable',
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ], 422);
        }

        $user->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data user berhasil diupdate.',
        ]);
    }

    public function updateAvatar(Request $request)
    {
        try {
            $user = Auth::user();

            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $avatar = $request->file('avatar');
            $result = Cloudinary::upload($avatar->getPathname(), [
                'resource_type' => 'image',
                'folder' => 'careerfund/user',
                'public_id' => uniqid(),
            ]);

            $user->url_icon = $result->getSecurePath();
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Avatar berhasil diupdate.',
                'url' => $result->getSecurePath(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate avatar: ' . $e->getMessage(),
            ], 422);
        }
    }

    public function deleteAvatar(Request $request)
    {
        try {
            $user = Auth::user();

            Cloudinary::destroy($user->url_icon);

            $user->url_icon = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Avatar berhasil dihapus.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus avatar: ' . $e->getMessage(),
            ], 422);
        }
    }
}
