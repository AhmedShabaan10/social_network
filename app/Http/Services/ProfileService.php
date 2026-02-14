<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;


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
            $image->storeAs('profile_images', $imageName, 'public');
            $data['image'] = "storage/profile_images/{$imageName}";
            if ($user->image) {
                $oldImagePath = str_replace('storage/profile_images/', '', $user->image);
                Storage::disk('public')->delete('profile_images/' . $oldImagePath);
            }
        }
        $user->update($data);

        return $user;
    }

}
;