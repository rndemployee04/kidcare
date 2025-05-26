<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KidCare') }} - Parent Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="flex">
            <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform sm:transform-none sm:opacity-100 transition duration-200"
                id="sidebar">
                <div class="flex items-center justify-between h-16 px-6 bg-[#00bbae]">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-white text-xl font-bold">KidCare</a>
                    </div>
                    <button class="sm:hidden text-white"
                        onclick="document.getElementById('sidebar').classList.add('-translate-x-full')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <nav class="px-4 py-6">
                    <a href="{{ route('parent.dashboard') }}"
                        class="flex items-center p-2 mb-2 text-gray-800 hover:bg-indigo-50 rounded-lg {{ request()->routeIs('parent.dashboard') ? 'bg-indigo-100' : '' }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('parent.bookings') }}"
                        class="flex items-center p-2 mb-2 text-gray-800 hover:bg-indigo-50 rounded-lg {{ request()->routeIs('parent.bookings') ? 'bg-indigo-100' : '' }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        Bookings
                    </a>
                    <a href="#" class="flex items-center p-2 mb-2 text-gray-800 hover:bg-indigo-50 rounded-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        My Profile
                    </a>
                    <a href="#" class="flex items-center p-2 mb-2 text-gray-800 hover:bg-indigo-50 rounded-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        Activityi
                    </a>
                    <div class="mt-8">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center p-2 w-full text-gray-800 hover:bg-indigo-50 rounded-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="ml-0 sm:ml-64 flex-1">
                <!-- Top Bar -->
                <div class="bg-white shadow p-4 flex items-center justify-between sticky top-0 z-30">
                    <button class="sm:hidden text-gray-600"
                        onclick="document.getElementById('sidebar').classList.remove('-translate-x-full')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <div class="ml-auto flex items-center">
                        <div class="relative">
                            <button class="flex items-center text-gray-700 focus:outline-none">
                                <span class="mr-2">{{ Auth::user()->name }}</span>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&color=7F9CF5&background=EBF4FF"
                                    alt="User Avatar" class="h-8 w-8 rounded-full">
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="container mx-auto px-4 py-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
