<?php

namespace App\Http\Controllers;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CompanyActionController extends Controller
{
    public function profileUpdate(Request $request)
    {
        $companies = Auth::guard('company')->user();
        try {
            $request->validate([
                'name' => 'required',
                'email' => [
                    'required',
                    Rule::unique('users')->ignore($companies),
                ],
                'telephone' => [
                    'required',
                    Rule::unique('users')->ignore($companies),
                ],
                'region' => 'nullable',
                'city' => 'nullable',
                'postal' => 'nullable',
            ]);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ], 422);
        }

        $companies->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data user berhasil diupdate.',
        ]);
    }

    public function updateAvatar(Request $request)
    {
        try {
            $companies = Auth::guard('company')->user();

            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $avatar = $request->file('avatar');
            $result = Cloudinary::upload($avatar->getPathname(), [
                'resource_type' => 'image',
                'folder' => 'careerfund/company',
                'public_id' => uniqid(),
            ]);

            $companies->url_icon = $result->getSecurePath();
            $companies->save();

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
            $companies = Auth::guard('company')->user();

            Cloudinary::destroy($companies->url_icon);

            $companies->url_icon = "";
            $companies->save();

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
