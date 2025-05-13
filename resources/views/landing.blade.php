<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

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


<body class="bg-white text-gray-900 antialiased">

    <!-- Navbar -->
    <header
        class="fixed top-0 w-full z-50 backdrop-blur bg-white/70 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-600">KidCare</h1>
            <nav class="space-x-6 text-sm font-medium flex items-center">
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600">Home</a>
                <a href="#about" class="text-gray-700 hover:text-blue-600">About</a>

                @if (Route::has('login'))
                    @auth
                        @php $user = Auth::user(); @endphp
@if ($user && $user->role === 'carebuddy')
    <a href="{{ route('carebuddy.dashboard') }}"
        class="text-gray-700 hover:text-blue-600">Dashboard</a>
@else
    <a href="{{ route('dashboard') }}"
        class="text-gray-700 hover:text-blue-600">Dashboard</a>
@endif
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-700 hover:text-blue-600">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-gray-700 hover:text-blue-600">Register</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section
        class="min-h-screen flex flex-col items-center justify-center px-6 text-center pt-32 bg-gradient-to-br from-white via-blue-50 to-white">
        <h2 class="text-5xl md:text-6xl font-extrabold tracking-tight max-w-4xl leading-tight">
            Trusted, Flexible Childcare<br />
            From Your Own Community
        </h2>
        <p class="mt-6 text-lg md:text-xl text-gray-600 max-w-2xl">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus facilisis, justo vel pulvinar pretium, ante
            nisl tincidunt urna.
        </p>
        <div class="mt-10 flex flex-col sm:flex-row gap-4">
            <a href="#"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-full shadow-md transition">
                Get Started
            </a>
            <a href="#"
                class="bg-white border border-gray-300 hover:border-blue-600 text-gray-800 font-medium py-3 px-8 rounded-full transition">
                Learn More
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 bg-white" id="about">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-10">
                <div
                    class="p-6 bg-gray-50 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-semibold mb-2">Verified Caregivers</h3>
                    <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>
                </div>
                <div
                    class="p-6 bg-gray-50 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-semibold mb-2">Drop-in or Scheduled</h3>
                    <p class="text-gray-600">Proin eget justo id ligula eleifend fermentum.</p>
                </div>
                <div
                    class="p-6 bg-gray-50 rounded-2xl border border-gray-100 shadow-sm">
                    <h3 class="text-lg font-semibold mb-2">Community-Priced</h3>
                    <p class="text-gray-600">Vel convallis velit nunc nec quam.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Trust Section -->
    <section class="py-24 bg-gradient-to-b from-blue-50 to-white text-center">
        <div class="max-w-4xl mx-auto px-6">
            <h3 class="text-3xl font-bold mb-6">Why Families Trust KidCare</h3>
            <p class="text-gray-700 mb-6">Curabitur eget nibh nec lorem tincidunt fermentum.</p>
            <div class="grid sm:grid-cols-2 gap-6 text-left">
                <div
                    class="p-6 bg-white rounded-xl border border-gray-100 shadow-sm">
                    <h4 class="font-semibold text-lg mb-1">Transparent Reviews</h4>
                    <p class="text-gray-600">Integer eget sapien euismod, convallis purus sed.</p>
                </div>
                <div
                    class="p-6 bg-white rounded-xl border border-gray-100 shadow-sm">
                    <h4 class="font-semibold text-lg mb-1">Local & Trusted</h4>
                    <p class="text-gray-600">Donec vitae luctus mauris, ac aliquam tortor.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer
        class="bg-white border-t border-gray-200 py-10 text-sm text-gray-500 hover:text-blue-600 transition text-center">
        &copy; {{ date('Y') }} KidCare. All rights reserved.
    </footer>

</body>

</html>
