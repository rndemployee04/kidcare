<!DOCTYPE html>
<html lang="en" class="scroll-smooth" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))">

<head>
    <meta charset="UTF-8">
    <title>KidCare - Trusted Community Childcare</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        html {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>


<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased">

    <!-- Navbar -->
    <header
        class="fixed top-0 w-full z-50 backdrop-blur bg-white/70 dark:bg-gray-900/70 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-600 dark:text-blue-400">KidCare</h1>
            <nav class="space-x-6 text-sm font-medium flex items-center">
                <a href="{{ url('/') }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Home</a>
                <a href="#about" class="text-gray-700 dark:text-gray-200 hover:text-blue-600">About</a>

                @if (Route::has('login'))
                    @auth
                        @php $user = Auth::user(); @endphp
@if ($user && $user->role === 'carebuddy')
    <a href="{{ route('carebuddy.dashboard') }}"
        class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Dashboard</a>
@else
    <a href="{{ route('dashboard') }}"
        class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Dashboard</a>
@endif
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-gray-700 dark:text-gray-200 hover:text-blue-600">Register</a>
                        @endif
                    @endauth
                @endif

                <!-- Dark Mode Toggle -->
                <button @click="darkMode = !darkMode"
                    class="ml-4 text-sm text-gray-500 dark:text-gray-300 hover:text-blue-600 transition">
                    <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m8.66-12.34l-.71.71M4.05 19.95l-.71-.71M21 12h-1M4 12H3m16.95 7.05l-.71-.71M5.34 5.34l-.71-.71M12 5a7 7 0 100 14 7 7 0 000-14z" />
                    </svg>
                    <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path d="M17.293 13.293a8 8 0 01-10.586-10.586A8 8 0 1017.293 13.293z" />
                    </svg>
                </button>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section
        class="min-h-screen flex flex-col items-center justify-center px-6 text-center pt-32 bg-gradient-to-br from-white via-blue-50 to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <h2 class="text-5xl md:text-6xl font-extrabold tracking-tight max-w-4xl leading-tight">
            Trusted, Flexible Childcare<br />
            From Your Own Community
        </h2>
        <p class="mt-6 text-lg md:text-xl text-gray-600 dark:text-gray-300 max-w-2xl">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus facilisis, justo vel pulvinar pretium, ante
            nisl tincidunt urna.
        </p>
        <div class="mt-10 flex flex-col sm:flex-row gap-4">
            <a href="#"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-full shadow-md transition">
                Get Started
            </a>
            <a href="#"
                class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 hover:border-blue-600 text-gray-800 dark:text-gray-200 font-medium py-3 px-8 rounded-full transition">
                Learn More
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 bg-white dark:bg-gray-900" id="about">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-10">
                <div
                    class="p-6 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h3 class="text-lg font-semibold mb-2">Verified Caregivers</h3>
                    <p class="text-gray-600 dark:text-gray-300">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>
                </div>
                <div
                    class="p-6 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h3 class="text-lg font-semibold mb-2">Drop-in or Scheduled</h3>
                    <p class="text-gray-600 dark:text-gray-300">Proin eget justo id ligula eleifend fermentum.</p>
                </div>
                <div
                    class="p-6 bg-gray-50 dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h3 class="text-lg font-semibold mb-2">Community-Priced</h3>
                    <p class="text-gray-600 dark:text-gray-300">Vel convallis velit nunc nec quam.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Trust Section -->
    <section class="py-24 bg-gradient-to-b from-blue-50 to-white dark:from-gray-800 dark:to-gray-900 text-center">
        <div class="max-w-4xl mx-auto px-6">
            <h3 class="text-3xl font-bold mb-6">Why Families Trust KidCare</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-6">Curabitur eget nibh nec lorem tincidunt fermentum.</p>
            <div class="grid sm:grid-cols-2 gap-6 text-left">
                <div
                    class="p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h4 class="font-semibold text-lg mb-1">Transparent Reviews</h4>
                    <p class="text-gray-600 dark:text-gray-400">Integer eget sapien euismod, convallis purus sed.</p>
                </div>
                <div
                    class="p-6 bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h4 class="font-semibold text-lg mb-1">Local & Trusted</h4>
                    <p class="text-gray-600 dark:text-gray-400">Donec vitae luctus mauris, ac aliquam tortor.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer
        class="bg-white dark:bg-gray-900 border-t dark:border-gray-700 py-10 text-sm text-gray-500 dark:text-gray-400 text-center">
        &copy; {{ date('Y') }} KidCare. All rights reserved.
    </footer>

</body>

</html>
