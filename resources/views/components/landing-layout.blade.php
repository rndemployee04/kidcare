<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KidCare') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.7.3/dist/alpine.min.js" defer></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
</head>

<body class="font-sans antialiased">
    <!-- Header -->
    <flux:header container
        class="dark:bg-zinc-900  dark:border-zinc-700 max-w-[1140px] mx-auto flex items-center header-phone">
        <flux:sidebar.toggle class="lg:hidden bg-amber-500" icon="bars-3" inset="left" />

        <flux:brand href="#" class="max-lg:hidden dark:hidden">
            <h1 class="text-[24px] font-bold text-[#ff8904]">KidCare</h1>
        </flux:brand>
        <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
            class="max-lg:hidden! hidden dark:flex" />

        <flux:navbar class="-mb-px max-lg:hidden justify-end w-full ">
            <flux:navbar.item href="/">Home</flux:navbar.item>
            <flux:navbar.item href="#">About</flux:navbar.item>
            <flux:navbar.item href="{{ route('explore') }}" current>Explore Carebuddies</flux:navbar.item>

            @if (Route::has('login'))
                @auth
                    @php $user = Auth::user(); @endphp
                    @if ($user && $user->role === 'carebuddy')
                        <flux:navbar.item href="{{ route('carebuddy.dashboard') }}">Dashboard</flux:navbar.item>
                    @else
                        <flux:navbar.item href="{{ route('dashboard') }}">Dashboard</flux:navbar.item>
                    @endif
                @else
                    <flux:navbar.item href="{{ route('login') }}">Login</flux:navbar.item>
                    @if (Route::has('register'))
                        <flux:navbar.item href="{{ route('register') }}">Register</flux:navbar.item>
                    @endif
                @endauth
            @endif

            <flux:separator vertical variant="subtle" class="my-2" />
        </flux:navbar>

        <flux:spacer />
    </flux:header>


    <!-- Mobile Menu -->
    <flux:sidebar stashable sticky
        class="lg:hidden bg-zinc-50 dark:bg-zinc-900 border rtl:border-r-0 rtl:border-l border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:brand href="#" class="px-2 dark:hidden">
            <h1 class="text-[24px] font-bold text-[#ff8904]">KidCare</h1>
        </flux:brand>
        <flux:brand href="#" logo="https://fluxui.dev/img/demo/dark-mode-logo.png" name="Acme Inc."
            class="px-2 hidden dark:flex" />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="#" current>Home</flux:navlist.item>
            @if (Route::has('login'))
                @auth
                    @php $user = Auth::user(); @endphp
                    @if ($user && $user->role === 'carebuddy')
                        <flux:navlist.item icon="user-circle" href="{{ route('carebuddy.dashboard') }}">Dashboard
                        </flux:navlist.item>
                    @else
                        <flux:navlist.item icon="user-circle" href="{{ route('dashboard') }}">Dashboard</flux:navlist.item>
                    @endif
                @else
                    <flux:navlist.item icon="document-text" href="{{ route('login') }}">Login</flux:navlist.item>
                    @if (Route::has('register'))
                        <flux:navlist.item icon="calendar" href="{{ route('register') }}">Register</flux:navlist.item>
                    @endif
                @endauth
            @endif
        </flux:navlist>

        <flux:spacer />
    </flux:sidebar>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="mt-16 px-6 py-12 bg-gradient-to-r from-[#fff6eb] to-[#ebfffe] pt-[220px]">
        <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 text-gray-800">

            <!-- Logo & About -->
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <h3 class="text-2xl font-bold text-teal-600">KidCare</h3>
                </div>
                <p class="text-sm">In our Adult Participation programs, for most students, it is their first program in
                    Kindedo.</p>
                <div class="flex gap-4 mt-4 text-white">
                    <div
                        class="bg-[#2ba7c1] rounded-full w-10 h-10 flex items-center justify-center
              transition-transform duration-300 hover:bg-[#1f8aa6] hover:scale-110 cursor-pointer">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                    <div
                        class="bg-[#2ba7c1] rounded-full w-10 h-10 flex items-center justify-center
              transition-transform duration-300 hover:bg-[#1f8aa6] hover:scale-110 cursor-pointer">
                        <i class="fab fa-twitter"></i>
                    </div>
                    <div
                        class="bg-[#2ba7c1] rounded-full w-10 h-10 flex items-center justify-center
              transition-transform duration-300 hover:bg-[#1f8aa6] hover:scale-110 cursor-pointer">
                        <i class="fab fa-youtube"></i>
                    </div>
                </div>


            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-bold text-lg mb-3">Quick links</h4>
                <ul class="space-y-2 text-sm">
                    <li>About</li>
                    <li>Courses</li>
                    <li>Shop</li>
                    <li>Pages</li>
                    <li>Blog</li>
                    <li>Contact</li>
                </ul>
            </div>

            <!-- Programs -->
            <div>
                <h4 class="font-bold text-lg mb-3">Programs</h4>
                <ul class="space-y-2 text-sm">
                    <li>Play School</li>
                    <li>Nursery</li>
                    <li>Junior Kg</li>
                    <li>Senior Kg</li>
                    <li>Holiday Camp</li>
                    <li>Day Care</li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="font-bold text-lg mb-3">Contact Us</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center gap-2">
                        <i class="fa fa-map-marker text-teal-600 w-4 h-4"></i>
                        14/A, Kilix Home Tower, NYC
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa fa-phone text-teal-600 w-4 h-4"></i>
                        907-200-3462
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fa fa-envelope text-teal-600 w-4 h-4"></i>
                        Support@kindedo.com
                    </li>
                </ul>
            </div>


        </div>
    </footer>
    <style>
        @keyframes bd-updown {
            0% {
                transform: translate(-50%, -50%) translateY(0);
            }

            100% {
                transform: translate(-50%, -50%) translateY(-20px);
            }
        }

        .animate-bd-updown {
            animation: bd-updown 1.5s infinite alternate ease-in-out;
        }

        @media (max-width: 767px) {

            .header-phone svg,
            .whitespace-nowrap svg {
                color: #000;
                width: 30px;
                height: 30px;
            }
        }
    </style>
    <!-- Mobile menu toggle script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('[aria-expanded]');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    const expanded = this.getAttribute('aria-expanded') === 'true' || false;
                    this.setAttribute('aria-expanded', !expanded);
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>

</html>
