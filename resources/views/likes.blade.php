<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            People who liked this post
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @forelse($likes as $like)
                <div class="flex items-center space-x-4 bg-white shadow rounded-md p-4">
                    <img src="{{ asset($like->image) }}" class="w-10 h-10 rounded-full object-cover border" alt="{{ $like->name }}">
                    <p class="text-gray-800">{{ $like->name }}</p>
                </div>
            @empty
                <p class="text-gray-500">No one has liked this post yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
