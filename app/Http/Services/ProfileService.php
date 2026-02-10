<?php

namespace App\Http\Serveices;

use App\Models\User;

class ProfileService
{
    public function getProfile()
    {
        return auth()->user();
    }

    public function updateProfile($request)
    {
        $user = auth()->user();

        $data = $request->only('name', 'email', 'bio');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/profile_images', $imageName);

            $data['image'] = 'storage/profile_images/' . $imageName;
        }

        $user->update($data);

        return $user;
    }

    public function viewOthers($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }
        return $user;
    }
}
;