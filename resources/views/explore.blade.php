<x-landing-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Find Your Perfect Carebuddy</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Browse through our verified carebuddies and find the
                    perfect match for your child's needs</p>
            </div>

            <!-- Search and Filter Section -->
            <form method="GET" action="{{ route('explore') }}" class="bg-white/95 rounded-2xl shadow-lg px-6 py-4 mb-8">
                <div class="flex flex-wrap gap-2 items-center">
                    <!-- Search Input -->
                    <input type="text" name="search" value="{{ request('search') }}" 
                        placeholder="Search by name, city, etc..."
                        class="flex-1 min-w-[160px] max-w-[200px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    
                    <!-- Location -->
                    <select name="location" class="px-3 py-2 border rounded-lg min-w-[120px]">
                        <option value="">All Locations</option>
                        @foreach($carebuddies->pluck('city')->unique()->filter()->sort() as $city)
                            <option value="{{ $city }}" {{ request('location') == $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                    
                    <!-- Radius -->
                    <select name="radius" class="px-3 py-2 border rounded-lg min-w-[110px]">
                        <option value="">Any Radius</option>
                        <option value="2-3" {{ request('radius') == '2-3' ? 'selected' : '' }}>2-3 km</option>
                        <option value="3-4" {{ request('radius') == '3-4' ? 'selected' : '' }}>3-4 km</option>
                        <option value="4-5" {{ request('radius') == '4-5' ? 'selected' : '' }}>4-5 km</option>
                    </select>
                    
                    <!-- Child Age -->
                    <select name="child_age" class="px-3 py-2 border rounded-lg min-w-[100px]">
                        <option value="">Any Age</option>
                        <option value="2-3" {{ request('child_age') == '2-3' ? 'selected' : '' }}>2-3</option>
                        <option value="3-5" {{ request('child_age') == '3-5' ? 'selected' : '' }}>3-5</option>
                        <option value="5-8" {{ request('child_age') == '5-8' ? 'selected' : '' }}>5-8</option>
                        <option value="8-10" {{ request('child_age') == '8-10' ? 'selected' : '' }}>8-10</option>
                        <option value="all" {{ request('child_age') == 'all' ? 'selected' : '' }}>All</option>
                    </select>
                    
                    <!-- Category -->
                    <select name="category" class="px-3 py-2 border rounded-lg min-w-[120px]">
                        <option value="any">Any Category</option>
                        <option value="newlywed" {{ request('category') == 'newlywed' ? 'selected' : '' }}>Newlywed</option>
                        <option value="professional" {{ request('category') == 'professional' ? 'selected' : '' }}>Professional</option>
                        <option value="parent" {{ request('category') == 'parent' ? 'selected' : '' }}>Parent</option>
                        <option value="senior" {{ request('category') == 'senior' ? 'selected' : '' }}>Senior</option>
                    </select>
                    
                    <!-- Gender -->
                    <select name="gender" class="px-3 py-2 border rounded-lg min-w-[110px]">
                        <option value="any">Any Gender</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="others" {{ request('gender') == 'others' ? 'selected' : '' }}>Others</option>
                    </select>
                    
                    <!-- Buttons -->
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Apply
                        </button>
                        <a href="{{ route('explore') }}" class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Reset
                        </a>
                    </div>
                </div>
                
                <!-- Availability -->
                <div class="mt-3 pt-3 border-t border-gray-200">
                    <div class="flex flex-wrap gap-4 items-center">
                        <span class="text-xs font-semibold">Availability:</span>
                        @foreach(['morning' => 'Morning', 'afternoon' => 'Afternoon', 'evening' => 'Evening', 'full_day' => 'Full Day'] as $value => $label)
                            <label class="inline-flex items-center text-xs gap-1">
                                <input type="checkbox" name="availability[]" value="{{ $value }}" 
                                    {{ in_array($value, request('availability', [])) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                {{ $label }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </form>

            <!-- Carebuddies Grid -->
            @if ($carebuddies->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($carebuddies as $carebuddy)
                        <div
                            class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 border border-gray-100">
                            <!-- Profile Image and Basic Info -->
                            <div class="px-6 pt-8">
                                <div class="flex flex-col items-center">
                                    <div class="relative">
                                        @if ($carebuddy->profile_photo)
                                            <img src="{{ asset('storage/' . $carebuddy->profile_photo) }}"
                                                alt="{{ $carebuddy->user->name }}" 
                                                class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg">
                                        @else
                                            <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center border-4 border-white shadow-lg">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                    </path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <!-- Verification Badge -->
                                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 shadow-md">
                                                <svg class="h-3 w-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                                    <circle cx="4" cy="4" r="3" />
                                                </svg>
                                                Verified
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Name and Rating -->
                                    <div class="mt-4 text-center">
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $carebuddy->user->name }}</h3>
                                        <div class="flex items-center justify-center mt-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= ($carebuddy->rating ?? 5))
                                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endif
                                            @endfor
                                            <span class="ml-1 text-sm text-gray-600">({{ $carebuddy->reviews_count ?? 0 }})</span>
                                        </div>
                                        <div class="mt-1 text-sm text-orange-500 font-medium">
                                            ${{ number_format(rand(15, 30), 2) }}/hr
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Info -->
                            <div class="px-6 pb-5">
                                <div class="text-center mb-4">
                                    <div class="flex items-center text-gray-500 text-sm justify-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $carebuddy->city }}, {{ $carebuddy->state }}
                                    </div>
                                </div>

                                <p class="mt-3 text-gray-600 text-sm line-clamp-2">
                                    {{ $carebuddy->bio ?? 'Experienced and caring babysitter with a passion for children\'s development and well-being.' }}
                                </p>

                                <div class="mt-6 pt-4 border-t border-gray-100">
                                    <div class="flex justify-between items-center">
                                        <a href="{{ route('explore.show', $carebuddy->id) }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                                            View Profile
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                        @auth
                                            @if (auth()->user()->role === 'parent')
                                                <a href="{{ route('parent.book.slot', $carebuddy->id) }}"
                                                    class="px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 transition duration-200">
                                                    Book Now
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}"
                                                class="px-4 py-2 bg-orange-500 text-white text-sm font-medium rounded-lg hover:bg-orange-600 transition duration-200">
                                                Book
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if ($carebuddies->hasPages())
                    <div class="mt-12 flex justify-center">
                        <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            @if ($carebuddies->onFirstPage())
                                <span
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $carebuddies->previousPageUrl() }}"
                                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Previous</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @endif

                            @foreach ($carebuddies->getUrlRange(1, $carebuddies->lastPage()) as $page => $url)
                                @if ($page == $carebuddies->currentPage())
                                    <span aria-current="page"
                                        class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            @if ($carebuddies->hasMorePages())
                                <a href="{{ $carebuddies->nextPageUrl() }}"
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            @else
                                <span
                                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400">
                                    <span class="sr-only">Next</span>
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            @endif
                        </nav>
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">No carebuddies found</h3>
                    <p class="mt-1 text-gray-500">We couldn't find any carebuddies matching your criteria.</p>
                </div>
            @endif
        </div>
    </div>
</x-landing-layout>
