<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return response()->json([
            'user' => $user,
        ]);
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

        return response()->json([
            'message' => 'Data user berhasil diupdate.',
            'user' => $user,
        ]);
    }

    public function updateAvatar(Request $request)
    {
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
            'message' => 'Avatar berhasil diupdate.',
            'user' => $user->name,
            'url' => $result->getSecurePath(),
        ]);
    }

    public function deleteAvatar()
    {
        $user = Auth::user();

        Cloudinary::destroy($user->url_icon);

        $user->url_icon = null;
        $user->save();

        return response()->json([
            'message' => 'Avatar berhasil dihapus.',
            'user' => $user->name,
            'url' => $user->url_icon
        ]);
    }
}
