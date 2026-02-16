<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                All Posts
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @foreach ($posts as $post)
                <div class="bg-white shadow rounded-md p-4 flex space-x-4 items-start">

                    {{-- User Image --}}
                    <div>
                        <img class="w-10 h-10 rounded-full object-cover border"
                             src="{{ asset($post->user->image) ?? 'https://via.placeholder.com/150' }}"
                             alt="{{ $post->user->name }}">
                    </div>

                    {{-- Post Content --}}
                    <div class="flex-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-lg font-medium text-gray-900">{{ $post->content }}</h2>
                                <p class="text-sm text-gray-600">
                                    by {{ $post->user_id == Auth::id() ? 'you' : $post->user->name }}
                                </p>
                            </div>

                            <a href="/posts/{{ $post->id }}"
                               class="text-blue-600 hover:underline text-sm">
                                View
                            </a>
                        </div>

                        {{-- Post Image --}}
                        @if($post->image)
                            <div class="mt-2">
                                <img src="{{ asset($post->image) }}" alt="Post Image"
                                     class="w-48 h-48 rounded-lg object-cover border">
                            </div>
                        @endif

                        {{-- Likes & Comments --}}
                        <div class="mt-3 flex items-center space-x-6 text-sm">

                            {{-- LIKE BUTTON --}}
                            <form action="{{ route('posts.like', $post->id) }}" method="POST">
                                @csrf
                                <button class="text-blue-600 hover:underline">
                                    👍 Like ({{ $post->likes()->count() }})
                                </button>
                            </form>

                            {{-- Comments count --}}
                            <span class="text-gray-600">
                                💬 {{ $post->comments()->count() }} Comments
                            </span>

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>
