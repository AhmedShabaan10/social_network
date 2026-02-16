<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Post
            </h2>

            <a href="{{ route('posts.show', $post->id) }}"
               class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Edit Post Form --}}
            <div class="bg-white shadow-md rounded-lg p-6">
                
                <form action="/posts/{{ $post->id }}" 
                      method="POST" 
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- Content --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea name="content" rows="4"
                                  class="w-full mt-2 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ $post->content }}</textarea>
                    </div>

                    {{-- Current Image --}}
                    @if ($post->image)
                        <div class="mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-1">Current Image</p>
                            <img src="{{ asset($post->image) }}" 
                                 class="w-full max-h-64 object-cover rounded-md border">
                        </div>
                    @endif

                    {{-- Upload New Image --}}
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Upload New Image (optional)</label>
                        <input type="file" name="image"
                               class="mt-2 block w-full text-sm text-gray-700 file:bg-indigo-600 file:text-white file:px-4 file:py-2 file:rounded-md file:border-0">
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-6 flex justify-between">

                        {{-- UPDATE --}}
                        <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-black rounded-md hover:bg-indigo-700">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
