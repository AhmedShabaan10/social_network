<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My website</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8" src="https://laracasts.com/images/logo/logo-triangle.svg"
                                alt="Your Company">
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <x-nav-link href="/home" :active="request()->is('home')">Home</x-nav-link>
                                <x-nav-link href="/posts" :active="request()->is('posts')">Posts</x-nav-link>
                                <x-nav-link href="/friends" :active="request()->is('friends')">Add Friends</x-nav-link>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <!-- Notifications Bell -->
                        <div class="relative">
                            <button type="button" class="text-white focus:outline-none" id="notificationButton">
                                <i class="fas fa-bell fa-lg"></i>
                                <span class="absolute top-0 right-0 inline-block w-2.5 h-2.5 transform translate-x-2 -translate-y-2 bg-red-600 rounded-full"></span>
                            </button>
                    
                            <!-- Dropdown -->
                            <div class="hidden absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg" id="notificationDropdown">
                                <ul class="py-1">
                                    <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notification 1</a></li>
                                    <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notification 2</a></li>
                                    <li><a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notification 3</a></li>
                                </ul>
                            </div>
                        </div>
                        <script>
                            const notificationButton = document.getElementById('notificationButton');
                            const notificationDropdown = document.getElementById('notificationDropdown');
                        
                            notificationButton.addEventListener('click', () => {
                                notificationDropdown.classList.toggle('hidden');
                            });
                        </script>
                        

                        @auth
                            <form method="POST" action="/logout">
                                @csrf
                                <button type='submit' class="text-white">Log Out</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>
        <main>
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
