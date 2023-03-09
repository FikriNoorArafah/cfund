<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Supabase\SupabaseClient;
use Illuminate\Validation\Rule;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user() ?? (object) ['name' => 'Guest'];

        if (request()->ajax()) {
            return response()->json([
                'user' => $user,
            ]);
        }

        return view('user.profile', compact('user'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'second_name' => 'nullable|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->user_id, 'user_id'),
            ],
            'telephone' => [
                'required',
                'string',
                'min:10',
                Rule::unique('users')->ignore($user->user_id, 'user_id'),
            ],
            'region' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'postal' => 'nullable|string|max:255',
            'education' => 'nullable|string|max:255',
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'second_name' => $request->second_name,
            'telephone' => $request->telephone,
            'region' => $request->region,
            'city' => $request->city,
            'postal' => $request->postal,
            'education' => $request->education,
        ];

        $user->update($data);

        if (request()->ajax()) {
            return response()->json([
                'message' => 'Data user berhasil diupdate.',
                'user' => $user,
            ]);
        };

        return view('user.profile', compact('user'));
    }

    // public function updateAvatar(Request $request)
    // {
    //     $user = Auth::user();

    //     $request->validate([
    //         'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $supabase = new SupabaseClient(env('SUPABASE_URL'), env('SUPABASE_KEY'));
    //     $bucketName = 'src';
    //     $filePath = $request->file('avatar')->getPathname();
    //     $fileName = $request->file('avatar')->getClientOriginalName();
    //     $response = $supabase->storage()->upload($bucketName, $fileName, $filePath);

    //     $user->icon_url = $response['publicURL'];
    //     $user->User::save();

    //     if (request()->ajax()) {
    //         return response()->json([
    //             'message' => 'Avatar berhasil diupdate.',
    //             'user' => $user,
    //             'avatar_url' => $response['publicURL'],
    //         ]);
    //     };

    //     return view('user.profile', compact('user'));
    // }
    // public function deleteAvatar()
    // {
    //     $user = Auth::user();

    //     $supabase = new SupabaseClient(env('SUPABASE_URL'), env('SUPABASE_KEY'));
    //     $bucketName = 'src';
    //     $fileName = basename($user->icon_url);
    //     $supabase->storage()->remove($bucketName, $fileName);

    //     $user->icon_url = null;
    //     $user->User::save();
    //     if (request()->ajax()) {
    //         return response()->json([
    //             'message' => 'Avatar berhasil dihapus.',
    //             'user' => $user,
    //         ]);
    //     };

    //     return view('user.profile', compact('user'));
    // }
}
