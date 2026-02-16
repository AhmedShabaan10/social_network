<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create a New Post
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-xl shadow-md border border-gray-100">

            {{-- Success / Error Messages --}}
            @if(session('success'))
                <div class="p-3 mb-3 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="p-3 mb-3 text-sm text-red-700 bg-red-100 rounded-lg">
                    <ul class="pl-4 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/posts" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Content --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        What's on your mind?
                    </label>

                    <textarea id="content" for="content" name="content" rows="4"
                        class="mt-2 block w-full rounded-lg border border-gray-300 shadow-sm
                               focus:border-blue-500 focus:ring-blue-500 text-sm"
                        required>{{ old('content') }}</textarea>
                </div>

                {{-- Image Upload --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Add Image (Optional)</label>

                    <input type="file"
                        name="image"
                        for="image"
                        accept="image/*"
                        class="mt-2 block w-full text-sm text-gray-900 cursor-pointer"
                        onchange="previewImage(event)">

                    <div class="mt-4 hidden" id="previewContainer">
                        <img id="previewImage" class="w-40 h-40 object-cover rounded-lg shadow-md border border-gray-300">
                    </div>
                </div>

                {{-- Submit --}}
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg
                               shadow hover:bg-blue-700 focus:ring focus:ring-blue-300">
                        Create Post
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS Preview --}}
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewContainer').classList.remove('hidden');
                document.getElementById('previewImage').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    </script>

</x-app-layout>
