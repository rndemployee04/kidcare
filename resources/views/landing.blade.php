<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KidCare - Trusted Community Childcare</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <style>
        html {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>


<body class="bg-white text-gray-900 antialiased">

    <!-- Navbar -->
    <header class="fixed top-0 w-full z-50 backdrop-blur bg-white/70 border-b border-gray-200">
        <div class="max-w-[1140px] mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-[24px] font-bold text-[#ff8904]">KidCare</h1>
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
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-blue-600">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-700 hover:text-blue-600">Register</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-[#fdf3eb] to-[#e9f7f7] overflow-hidden">
        <div class="max-w-[1140px] mx-auto">
            <!-- Bottom Shape -->
            <div class="hidden md:block absolute bottom-0 left-0 w-full">
                <img src="{{ url('images/line.png') }}" alt="hero" class="animate-bd-updown"
                    style="transform: translate(-50%, -50%);">
            </div>
            <div class="absolute top-[230px] right-[110px] z-0">
                <img src="{{ url('images/line2.png') }}" alt="hero" class="animate-bd-updown"
                    style="transform: translate(-50%, -50%);">
            </div>

            <div class="relative z-10 max-w-7xl mx-auto pt-[100px]">
                <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-10">

                    <!-- Left Content -->
                    <div>
                        <span class="text-[20px] text-[#ff8904] font-semibold block mb-3" data-aos="fade-down">Welcome
                            To Childcare
                            Service</span>
                        <h1 class="text-[66px] font-black text-gray-900 leading-tight mb-6" data-aos="fade-left">Get
                            Lifecare For <br>Your
                            Kids</h1>
                        <a href="shop.html"
                            class="inline-block bg-orange-400 hover:bg-orange-500 text-white font-semibold px-6 py-3 rounded-full transition-all duration-300"
                            data-aos="fade-up">
                            Apply Now
                        </a>
                    </div>

                    <!-- Right Image -->
                    <div class="relative">
                        <div class="relative z-10">
                            <img src="{{ url('images/hero-1.png') }}" alt="hero">
                        </div>
                        <div class="absolute top-1/2 left-1/2 w-[90%] z-0 animate-bd-updown"
                            style="transform: translate(-50%, -50%);">
                            <img src="{{ url('images/download11.svg') }}" alt="Shape not found"
                                class="w-[300px] md:w-[400px] mx-auto">
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-white" id="bd-promotion-area">
        <div class="max-w-[1140px] mx-auto">
            <div class="flex flex-col lg:flex-row items-center gap-10">
                <!-- Left Image/Thumb -->
                <div class="w-full lg:w-1/2">
                    <div class="relative mb-10 animate-fade-in-left">
                        <div class="relative">
                            <img src={{ url('images/kids-13.jpg') }} alt="Image not found"
                                class="rounded-lg shadow-lg w-full" />
                        </div>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="w-full lg:w-1/2">
                    <div class="mb-10 animate-fade-in-right">
                        <div class="mb-6">
                            <h2 class="text-3xl font-bold text-gray-800 mb-3" data-aos="fade-right">About Us</h2>
                            <p class="text-gray-600" data-aos="fade-left">
                                Being brave isn’t always a grand gesture — sometimes it just means having a go,
                                attempting
                                that difficult question, offering an answer in a lesson when you’re simply really trying
                                new.
                            </p>
                        </div>

                        <!-- Counters -->
                        <div class="flex flex-wrap justify-center gap-[30px] px-10 py-4 rounded-[24px] bg-[#00bbae] mb-8"
                            data-aos="fade-up">
                            <div class="flex items-center gap-[10px] text-white">
                                <p class="text-3xl font-bold"><span class="counter">14</span>+</p>
                                <p class="text-sm text-left">Years of<br>experience</p>
                            </div>
                            <div class="flex items-center gap-[10px] text-white">
                                <p class="text-3xl font-bold"><span class="counter">7</span>K+</p>
                                <p class="text-sm text-left">Students<br>each year</p>
                            </div>
                            <div class="flex items-center gap-[10px] text-white">
                                <p class="text-3xl font-bold"><span class="counter">15</span>+</p>
                                <p class="text-sm">Award<br>Wining</p>
                            </div>
                        </div>


                        <!-- List -->
                        <ul class="list-disc list-inside text-gray-700 mb-10 space-y-2">
                            <li data-aos="fade-right">We believe every child is intelligent so we care.</li>
                            <li data-aos="fade-left">Teachers make a difference of your child.</li>
                        </ul>

                        <!-- Buttons -->
                        <div class="flex flex-wrap items-center gap-4">
                            <a href="#"
                                class=" bg-orange-400 hover:bg-orange-500 text-white font-semibold px-6 py-3 rounded-full transition-all duration-300"
                                data-aos="fade-up">View
                                More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 px-4 bg-white">
        <div class="max-w-[1140px] mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">

            <!-- Left Text Content -->
            <div>
                <p class="text-sm font-semibold text-gray-800" data-aos="fade-down"> Benefits</p>
                <h2 class="text-3xl sm:text-4xl font-bold text-black-500 leading-tight mt-2 mb-8"
                    data-aos="fade-right">
                    Why Choose KidCare?
                </h2>

                <!-- Grid Items -->
                <div class="grid grid-cols-1 sm:grid-cols-2  gap-x-8 relative">

                    <!-- Feature Item -->
                    <div class="relative pl-6 border-l-2 border-orange-500">
                        <div
                            class="absolute -left-2 top-1 w-4 h-4 bg-orange-500 border-4 border-white rounded-full shadow">
                        </div>
                        <h4 class="text-black-500 font-semibold mb-1" data-aos="fade-down">Earn supplemental income
                            while your child plays.
                        </h4>
                        <p class="text-sm text-gray-600 pb-[35px]" data-aos="fade-down">
                            Uses less power, often relying on solar energy or low-energy sensors.
                        </p>
                    </div>

                    <div class="relative pl-6 border-l-2 border-orange-500">
                        <div
                            class="absolute -left-2 top-1 w-4 h-4 bg-orange-500 border-4 border-white rounded-full shadow">
                        </div>
                        <h4 class="text-black-500 font-semibold mb-1" data-aos="fade-down">Create healthy social
                            interactions for your kid.
                        </h4>
                        <p class="text-sm text-gray-600 pb-[35px]" data-aos="fade-down">
                            Made with recyclable or sustainable materials, reducing environmental impact
                        </p>
                    </div>

                    <div class="relative pl-6 border-l-2 border-orange-500">
                        <div
                            class="absolute -left-2 top-1 w-4 h-4 bg-orange-500 border-4 border-white rounded-full shadow">
                        </div>
                        <h4 class="text-black-500 font-semibold mb-1" data-aos="fade-up">Choose who, when, and where
                            play sessions happen.
                        </h4>
                        <p class="text-sm text-gray-600 pb-[35px]" data-aos="fade-up">
                            Avoids hazardous materials like mercury, making it safer for people and the planet.
                        </p>
                    </div>

                    <div class="relative pl-6 border-l-2 border-orange-500">
                        <div
                            class="absolute -left-2 top-1 w-4 h-4 bg-orange-500 border-4 border-white rounded-full shadow">
                        </div>
                        <h4 class="text-black-500 font-semibold mb-1" data-aos="fade-down">Enjoy fulfilling, joyful
                            experiences with kids.
                        </h4>
                        <p class="text-sm text-gray-600 pb-[35px]" data-aos="fade-down">
                            Bras fringilla conubia odios metus torquent commodo quam
                        </p>
                    </div>

                    <div class="relative pl-6 border-l-2 border-orange-500">
                        <div
                            class="absolute -left-2 top-1 w-4 h-4 bg-orange-500 border-4 border-white rounded-full shadow">
                        </div>
                        <h4 class="text-black-500 font-semibold mb-1" data-aos="fade-up">A safe way to experience
                            caregiving or
                            mentorship.</h4>
                        <p class="text-sm text-gray-600" data-aos="fade-up">
                            Bras fringilla conubia odios metus torquent commodo quam
                        </p>
                    </div>

                    <div class="relative pl-6 border-l-2 border-orange-500">
                        <div
                            class="absolute -left-2 top-1 w-4 h-4 bg-orange-500 border-4 border-white rounded-full shadow">
                        </div>
                        <h4 class="text-black-500 font-semibold mb-1" data-aos="fade-down">Build community reputation
                            and experience.</h4>
                        <p class="text-sm text-gray-600" data-aos="fade-down">
                            Build community reputation and experience.
                        </p>
                    </div>

                </div>
            </div>

            <!-- Right Image -->
            <div>
                <img src="{{ url('images/kids-3.jpg') }}" alt="Power Washing"
                    class="w-full h-[500px] object-cover rounded-md border border-gray-200 shadow-sm" />
            </div>
        </div>
    </section>

    <section class="Serve py-[70px] bg-[linear-gradient(100.88deg,_#EBFFFE_0.6%,_#FFF6EB_100%)]">
        <div class="max-w-[1140px] mx-auto">
            <h2 class="text-3xl font-bold text-center mb-10" data-aos="fade-down">Who We Serve</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-300"
                    data-aos="fade-down">
                    <h3 class="text-xl font-semibold mb-2">Parents with Young Children</h3>
                    <p><strong>Who:</strong> Ages 25–40</p>
                    <p><strong>Needs:</strong> Safe, fun, and educational childcare options</p>
                    <p><strong>Challenges:</strong> Balancing work and family time, finding trustworthy care</p>
                    <p><strong>Behavior:</strong> Use social media for recommendations</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-300"
                    data-aos="fade-up">
                    <h3 class="text-xl font-semibold mb-2">Adults without Children</h3>
                    <p><strong>Who:</strong> Ages 20–45</p>
                    <p><strong>Needs:</strong> Lifestyle, wellness, and community resources</p>
                    <p><strong>Challenges:</strong> Less familiarity with childcare needs, prefer straightforward info
                    </p>
                    <p><strong>Behavior:</strong> Engage with concise and relatable content</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-300"
                    data-aos="fade-down">
                    <h3 class="text-xl font-semibold mb-2">Parents of Only-Children</h3>
                    <p><strong>Who:</strong> Ages 28–45</p>
                    <p><strong>Needs:</strong> Quality educational and social activities tailored to their child</p>
                    <p><strong>Challenges:</strong> Ensuring socialization and meeting high parenting expectations</p>
                    <p><strong>Behavior:</strong> Invest in personalized, expert-guided care</p>
                </div>

                <!-- Card 4 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-300"
                    data-aos="fade-up">
                    <h3 class="text-xl font-semibold mb-2">Educators, Therapists, Caregivers</h3>
                    <p><strong>Who:</strong> Ages 25–60</p>
                    <p><strong>Needs:</strong> Access to resources, evidence-based tools, and collaboration
                        opportunities</p>
                    <p><strong>Challenges:</strong> Budget limits, diverse needs, and time constraints</p>
                    <p><strong>Behavior:</strong> Research-driven, use digital tools, and engage in professional
                        communities</p>
                </div>

            </div>
        </div>
    </section>


    <section class="bg-[#f9f9f9] py-16 mb-[75px]">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-black-700 mb-4" data-aos="fade-down">What Parents Say</h2>
            <p class="text-gray-600 mb-2" data-aos="fade-up">
                Rapidiously expedite granular imperatives before economically sound web services.
            </p>
            <p class="text-gray-600 mb-12" data-aos="fade-up">
                Credibly actualize pandemic strategic themeplatform.
            </p>

            <!-- Swiper Slider -->
            <div class="swiper testimonialSwiper !overflow-x-clip !overflow-visible ">
                <div class="swiper-wrapper">
                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="relative border-2 border-yellow-500 rounded-md p-6 pb-15 pt-10 bg-white">
                            <div class="absolute left-4 top-4 text-yellow-500 text-3xl font-bold">“</div>
                            <p class="text-gray-700 text-left">
                                Professionally predominate that timely infrastructures tops line methodologies<br />
                                Collaboratively seize scalable achannels before longterm high impact
                            </p>
                            <div class="mt-4 text-left">
                                <span class="text-[#ff3c00] font-bold">Joly Smith</span>
                                <span class="text-sm font-light italic"> ui/ux Designer</span>
                            </div>
                            <div class="absolute right-4 bottom-4 text-yellow-500 text-3xl font-bold">”</div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 -bottom-10 w-20 h-20 border-4 border-white rounded-full  bg-white">
                                <img src="{{ url('images/testimonial_03.jpg') }}" alt="Joly Smith"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="relative border-2 border-red-400 rounded-md p-6 pb-15 pt-10 bg-white">
                            <div class="absolute left-4 top-4 text-red-500 text-3xl font-bold">“</div>
                            <p class="text-gray-700 text-left">
                                Professionally predominate that timely infrastructures tops line methodologies<br />
                                Collaboratively seize scalable achannels before longterm high impact
                            </p>
                            <div class="mt-4 text-left">
                                <span class="text-[#ff3c00] font-bold">Joly Smith</span>
                                <span class="text-sm font-light italic"> ui/ux Designer</span>
                            </div>
                            <div class="absolute right-4 bottom-4 text-red-500 text-3xl font-bold">”</div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 -bottom-10 w-20 h-20 border-4 border-white rounded-full bg-white">
                                <img src="{{ url('images/testimonial_01.jpg') }}" alt="Joly Smith"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="relative border-2 border-orange-400 rounded-md p-6 pt-10 pb-15 bg-white">
                            <div class="absolute left-4 top-4 text-orange-500 text-3xl font-bold">“</div>
                            <p class="text-gray-700 text-left">
                                Professionally predominate that timely infrastructures tops line methodologies<br />
                                Collaboratively seize scalable achannels before longterm high impact
                            </p>
                            <div class="mt-4 text-left">
                                <span class="text-[#ff3c00] font-bold">Joly Smith</span>
                                <span class="text-sm font-light italic"> ui/ux Designer</span>
                            </div>
                            <div class="absolute right-4 bottom-4 text-orange-500 text-3xl font-bold">”</div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 -bottom-10 w-20 h-20 border-4 border-white rounded-full bg-white">
                                <img src="{{ url('images/testimonial_02.jpg') }}" alt="Joly Smith"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                    </div>
                    <!-- Slide 4 -->
                    <div class="swiper-slide">
                        <div class="relative border-2 border-orange-400 rounded-md p-6 pt-10 pb-15 bg-white">
                            <div class="absolute left-4 top-4 text-orange-500 text-3xl font-bold">“</div>
                            <p class="text-gray-700 text-left">
                                Professionally predominate that timely infrastructures tops line methodologies<br />
                                Collaboratively seize scalable achannels before longterm high impact
                            </p>
                            <div class="mt-4 text-left">
                                <span class="text-[#ff3c00] font-bold">Joly Smith</span>
                                <span class="text-sm font-light italic"> ui/ux Designer</span>
                            </div>
                            <div class="absolute right-4 bottom-4 text-orange-500 text-3xl font-bold">”</div>
                            <div
                                class="absolute left-1/2 transform -translate-x-1/2 -bottom-10 w-20 h-20 border-4 border-white rounded-full  bg-white">
                                <img src="{{ url('images/testimonial_01.jpg') }}" alt="Joly Smith"
                                    class="w-full h-full object-cover rounded-full">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Swiper Pagination -->
                <div class="swiper-pagination mt-8"></div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <div
        class="max-w-5xl mx-auto mt-10 bg-teal-600 rounded-2xl text-white text-center px-6 py-12 relative overflow-hidden mb-[-214px]">
        <h2 class="text-4xl font-bold mb-3" data-aos="fade-down">Join Our Newsletter</h2>
        <p class="mb-6" data-aos="fade-up">Subscribe our newsletter to get our latest update & news.</p>
        <form class="flex justify-center items-center flex-wrap gap-2 sm:gap-0 relative z-10">
            <input type="email" placeholder="your email"
                class="bg-white px-5 py-3 rounded-full text-gray-800 w-[280px] sm:w-[400px] focus:outline-none" />
            <button
                class="bg-orange-400 hover:bg-orange-500 text-white px-6 py-3 rounded-full flex items-center gap-2 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-white" viewBox="0 0 512 512">
                    <path
                        d="M476.3 3.7L12.3 270.7c-17.4 10.1-15 36.2 4 42l111.2 35.2 35.3 111.2c5.6 17.7 30.6 21.3 42.3 4l267-464C517.7 18.6 495.4-3.5 476.3 3.7zM152.7 328.5l159.8-159.8c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6L175.4 351.1l-22.7-22.6zm23.4 76.6L167 360l36.7 11.6-27.6 33.5z" />
                </svg>
                Subscribe Now
            </button>
        </form>
        <div class="absolute inset-0 opacity-10 bg-cover bg-center rounded-2xl"
            style="background-image: url('https://img.freepik.com/free-photo/front-view-still-life-books-graduation-cap_23-2149241203.jpg'); z-index: 0;">
        </div>
    </div>

    <!-- Footer Section -->
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
    </style>
    <script>
        AOS.init({
            duration: 1200,
        })
    </script>
    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper(".testimonialSwiper", {
            loop: true,
            pagination: {
                clickable: true,
            },
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 40,
                },
            },
        });
    </script>
</body>
</html>
