<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $this->profileService->getProfile(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->profileService->updateProfile($request);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

}
