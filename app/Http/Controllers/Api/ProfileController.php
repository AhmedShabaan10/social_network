<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Services\ProfileService;


class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show()
    {
        $profile = $this->profileService->getProfile();
        return response()->json([
            'status' => true,
            'profile' => [
                'image' => $profile->image ? asset($profile->image) : null,
                'name' => $profile->name,
                'email' => $profile->email,
                'bio' => $profile->bio
            ]
        ]);

    }

    public function update(UpdateProfileRequest $request)
    {
        $profile = $this->profileService->updateProfile($request);
        return response()->json([
            'status' => true,
            'profile' => [
                'image' => $profile->image ? asset($profile->image) : null,
                'name' => $profile->name,
                'email' => $profile->email,
                'bio' => $profile->bio
            ]
        ]);
    }
}