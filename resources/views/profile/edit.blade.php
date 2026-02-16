<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            @if ($user->image)
                <div class="w-full flex justify-center mb-6">
                    <img src="{{ asset($user->image) }}" 
                        alt="Profile Image" 
                        class="rounded-full object-cover shadow-lg border-4 border-gray-200"
                        style="width: 400px; height: 400px;">
                </div>
            @endif



            <div class="max-w-3xl mx-auto">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-3xl mx-auto">
                @include('profile.partials.update-password-form')
            </div>
        </div>

    </div>
</div>

</x-app-layout>
