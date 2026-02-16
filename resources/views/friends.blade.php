<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Friends & Requests
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- TABS --}}
            <div class="mb-6 flex space-x-4 border-b">
                <a href="#friends" class="px-4 py-2 font-medium text-gray-700 border-b-2 border-blue-500">Friends</a>
                <a href="#requests" class="px-4 py-2 font-medium text-gray-700 hover:border-b-2 hover:border-blue-500">Requests</a>
            </div>

            {{-- FRIENDS LIST --}}
            <div id="friends">
                <h3 class="text-lg font-semibold mb-4">Your Friends</h3>

                @forelse ($friends as $user)
                    <div class="mb-4 p-4 bg-white shadow rounded-md flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset($user->image ?? 'https://via.placeholder.com/50') }}" class="w-12 h-12 rounded-full object-cover border" alt="{{ $user->name }}">
                            <h2 class="text-lg font-medium text-gray-900">{{ $user->name }}</h2>
                        </div>
                        <span class="px-3 py-1 bg-green-500 text-white rounded-md text-sm font-medium cursor-not-allowed">
                            Friend
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500">You have no friends yet.</p>
                @endforelse
            </div>

            {{-- FRIEND REQUESTS --}}
            <div id="requests" class="mt-8">
                <h3 class="text-lg font-semibold mb-4">Friend Requests</h3>

                @forelse ($requests as $user)
                    <div class="mb-4 p-4 bg-white shadow rounded-md flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset($user->user->image ?? 'https://via.placeholder.com/50') }}" class="w-12 h-12 rounded-full object-cover border" alt="{{ $user->user->name }}">
                            <h2 class="text-lg font-medium text-gray-900">{{ $user->user->name }}</h2>
                        </div>
                        <div class="flex space-x-2">
                            <form action="/friends/accept/{{ $user->id }}" method="POST">
                                @csrf
                                <button class="px-4 py-2 bg-green-600 text-green rounded-md hover:bg-green-700 text-sm font-medium">
                                    Accept
                                </button>
                            </form>
                            <form action="/friends/reject/{{ $user->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm font-medium">
                                    Reject
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No pending friend requests.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>

<script>
    document.querySelectorAll('[href^="#"]').forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if(!target) return;

            document.querySelectorAll('#friends, #requests').forEach(section => section.classList.add('hidden'));
            target.classList.remove('hidden');
        });
    });

    document.getElementById('requests').classList.add('hidden');
</script>
