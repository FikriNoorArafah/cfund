<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function update(Request $request)
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
