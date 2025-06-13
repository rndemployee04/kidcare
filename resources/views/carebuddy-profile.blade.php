<x-landing-layout>

    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ url()->previous() }}" class="flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Results
                </a>
            </div>

            <!-- Profile Header -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
                <div class="md:flex">
                    <!-- Profile Image -->
                    <div class="md:w-1/3 bg-gray-100">
                        @if ($carebuddy->profile_photo)
                            <img src="{{ asset('storage/' . $carebuddy->profile_photo) }}"
                                alt="{{ $carebuddy->user->name }}" class="w-full h-80 md:h-full object-cover">
                        @else
                            <div
                                class="w-full h-80 md:h-full bg-gradient-to-r from-blue-50 to-cyan-50 flex items-center justify-center">
                                <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Profile Info -->
                    <div class="p-8 md:w-2/3">
                        <div class="flex justify-between items-start">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">{{ $carebuddy->user->name }}</h1>
                                <div class="flex items-center mt-2">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="ml-1 text-gray-700">{{ number_format($carebuddy->rating ?? 4.8, 1) }}
                                        ({{ $carebuddy->reviews_count ?? 0 }} reviews)</span>

                                    @if ($carebuddy->is_verified)
                                        <span
                                            class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor"
                                                viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3" />
                                            </svg>
                                            Verified
                                        </span>
                                    @endif
                                </div>
                                <div class="mt-4 flex items-center text-gray-600">
                                    <svg class="h-5 w-5 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $carebuddy->city }}, {{ $carebuddy->state }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-orange-500">
                                    ${{ number_format(rand(15, 30), 2) }}<span
                                        class="text-base font-normal text-gray-500">/hr</span></div>
                                <div class="mt-2">
                                    @auth
                                        @if (auth()->user()->role === 'parent'  && auth()->user()->verification_status === 'accepted')
                                            <a href="{{ route('parent.book.slot', $carebuddy->id) }}"
                                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                                Book Now
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                            Book
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>

                        <!-- About Section -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">About Me</h2>
                            <p class="mt-2 text-gray-600">
                                {{ $carebuddy->bio ?? 'Experienced and caring babysitter with a passion for children\'s development and well-being. I have worked with children of all ages and am certified in CPR and First Aid.' }}
                            </p>
                        </div>

                        <!-- Details Grid -->
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 text-orange-500">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Experience</p>
                                    <p class="text-sm text-gray-500">{{ $carebuddy->experience ?? '3' }}+ years</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 text-orange-500">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Skills</p>
                                    <div class="mt-1 flex flex-wrap gap-2">
                                        @foreach ($carebuddy->skills ?? ['Childcare', 'First Aid', 'CPR', 'Early Education'] as $skill)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 text-orange-500">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Response Time</p>
                                    <p class="text-sm text-gray-500">Within a few hours</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-6 w-6 text-orange-500">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Service Area</p>
                                    <p class="text-sm text-gray-500">{{ $carebuddy->city }}, {{ $carebuddy->state }}
                                        and
                                        surrounding areas</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-8">
                <div class="p-8">
                    <h2 class="text-xl font-medium text-gray-900">Reviews</h2>
                    @if (isset($carebuddy->reviews) && $carebuddy->reviews->count() > 0)
                        <div class="mt-6 space-y-8">
                            @foreach ($carebuddy->reviews as $review)
                                <div class="border-b border-gray-200 pb-6 last:border-0 last:pb-0">
                                    <div class="flex items-center">
                                        <div
                                            class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <span
                                                class="text-gray-600 font-medium">{{ substr($review->user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $review->user->name }}
                                            </h4>
                                            <div class="flex items-center mt-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $review->rating)
                                                        <svg class="h-4 w-4 text-yellow-400" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4 text-gray-300" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    @endif
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="ml-auto text-sm text-gray-500">
                                            {{ $review->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                    <div class="mt-3 text-sm text-gray-600">
                                        {{ $review->comment }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-6 text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No reviews yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Be the first to leave a review for
                                {{ $carebuddy->user->name }}!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>
