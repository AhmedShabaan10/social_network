<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Find Friends') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Search Form --}}
            <form action="{{ route('friends.search') }}" method="GET" class="mb-6">
                <input type="text" name="q"
                    placeholder="Search for users..."
                    class="w-full p-3 border rounded-lg focus:ring focus:ring-blue-300"
                    value="{{ request('q') }}">
            </form>

            {{-- Messages --}}
            @if(session('success'))
                <p class="text-green-600 mb-4">{{ session('success') }}</p>
            @endif
            @if(session('error'))
                <p class="text-red-600 mb-4">{{ session('error') }}</p>
            @endif

            {{-- Search Results --}}
            @isset($users)
                <h3 class="text-lg font-semibold mb-4">Search Results</h3>

                @forelse ($users as $user)
                    <div class="mb-4 p-4 bg-white shadow rounded-md flex items-center justify-between" id="user-{{ $user->id }}">
                        <div class="flex items-center space-x-4">
                            <img src="{{ asset($user->image ?? 'https://via.placeholder.com/50') }}"
                                class="w-12 h-12 rounded-full object-cover border">

                            <h2 class="text-lg font-medium text-gray-900">
                                {{ $user->name }}
                            </h2>
                        </div>

                        <div class="friend-action">
                            @php
                                $status = auth()->user()->isFriend($user);
                            @endphp

                            @if ($status === 1)
                                <button class="px-4 py-2 bg-green-600 text-white rounded-md cursor-not-allowed">
                                    Friends
                                </button>

                            @elseif ($status === 2)
                                <button class="px-4 py-2 bg-gray-500 text-white rounded-md cursor-not-allowed">
                                    Pending
                                </button>

                            @elseif ($status === 3)
                                <form class="accept-form" action="{{ route('friends.accept', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="px-4 py-2 bg-blue-600 text-white rounded-md">
                                        Accept Request
                                    </button>
                                </form>

                            @else
                                <form class="send-request-form" action="{{ route('friends.send', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                        Add Friend
                                    </button>
                                </form>
                            @endif

                        </div>
                    </div>

                @empty
                    <p class="text-gray-500">No users found.</p>
                @endforelse
            @endisset

        </div>
    </div>

    {{-- AJAX Script --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function () {

            // Add Friend AJAX
            $('.send-request-form').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let userDiv = form.closest('div#user-' + url.split('/').pop());

                $.post(url, form.serialize(), function(res){
                    form.replaceWith('<button class="px-4 py-2 bg-gray-500 text-white rounded-md cursor-not-allowed">Pending</button>');
                }).fail(function(xhr){
                    alert(xhr.responseJSON?.message || 'Something went wrong.');
                });
            });

            // Accept Friend AJAX
            $('.accept-form').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let userDiv = form.closest('div#user-' + url.split('/').pop());

                $.post(url, form.serialize(), function(res){
                    form.replaceWith('<button class="px-4 py-2 bg-green-600 text-white rounded-md cursor-not-allowed">Friends</button>');
                }).fail(function(xhr){
                    alert(xhr.responseJSON?.message || 'Something went wrong.');
                });
            });

        });
    </script>

</x-app-layout>
