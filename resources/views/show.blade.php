<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Post by {{ $post->user->name }}
            </h2>

            @if ($post->user_id == Auth::id())
                <a href="{{ route('posts.edit', $post->id) }}"
                   class="px-4 py-2 bg-indigo-600 text-black rounded-md hover:bg-indigo-700">
                    Edit Post
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Post Container --}}
            <div class="bg-white shadow-md rounded-lg p-6">

                <div class="flex items-center space-x-4 mb-4">
                    <img src="{{ asset($post->user->image) }}"
                         class="w-12 h-12 rounded-full border object-cover"
                         alt="User Image">

                    <div>
                        <h3 class="font-semibold text-gray-900 text-lg">{{ $post->user->name }}</h3>
                        <p class="text-gray-500 text-sm">
                            {{ $post->user_id == Auth::id() ? 'Posted by you' : 'Posted by ' . $post->user->name }}
                        </p>
                    </div>
                </div>

                <p class="text-gray-800 text-lg mb-4">{{ $post->content }}</p>

                @if ($post->image)
                    <img src="{{ asset($post->image) }}"
                         class="w-full max-h-72 object-cover rounded-md border mb-4"
                         alt="Post Image">
                @endif

                {{-- Like Button as link --}}
                <a href="{{ route('posts.likes', $post->id) }}"
                   class="inline-block px-4 py-2 text-black bg-green-600 rounded-md hover:bg-green-700">
                    👍 Show Likes ({{ $post->likes->count() }})
                </a>
            </div>

            {{-- Add Comment --}}
            <div class="bg-white shadow-md rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Add a Comment</h3>

                <form method="POST" action="/posts/{{ $post->id }}/comment">
                    @csrf
                    <textarea name="content" rows="3" required
                              class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 "></textarea>

                    <button type="submit" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Post Comment
                    </button>
                </form>
            </div>

            {{-- Comments Section --}}
            <div class="bg-white shadow-md rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                    Comments ({{ $post->comments->count() }})
                </h3>

                <div id="commentsList">
                    @forelse ($post->comments as $comment)
                        <div class="mb-4 p-4 bg-gray-100 rounded-md border">
                            <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                by {{ $comment->user->name }}
                            </p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No comments yet.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
