<div>
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Welcome, {{ $user->name }}</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">Find your perfect care buddy below.</p>
    </div>
    
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h4 class="text-xl font-semibold mb-6">Carebuddy Recommendations</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                @forelse($carebuddies as $carebuddy)
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="p-5">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500">
                                    @if($carebuddy->profile_photo)
                                        <img src="{{ $carebuddy->profile_photo }}" alt="{{ $carebuddy->user->name }}" class="h-12 w-12 rounded-full object-cover">
                                    @else
                                        <span class="text-lg font-medium">{{ substr($carebuddy->user->name, 0, 1) }}</span>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $carebuddy->user->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $carebuddy->city ?? 'Location N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-2 space-y-2">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    Service radius: {{ $carebuddy->service_radius ? $carebuddy->service_radius . ' km' : 'N/A' }}
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                    </svg>
                                    Age limit: {{ $carebuddy->child_age_limit ?? 'N/A' }}
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    Availability: {{ $carebuddy->availability ?? 'N/A' }}
                                </div>
                            </div>
                            
                            @if($carebuddy->bio)
                                <div class="mt-3">
                                    <p class="text-sm text-gray-600 line-clamp-3">{{ $carebuddy->bio }}</p>
                                </div>
                            @endif
                            
                            <div class="mt-4">
                                <a href="{{ route('parent.carebuddy.profile', $carebuddy->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 py-6 text-center">
                        <p class="text-gray-500">No carebuddies available at the moment. Please check back later.</p>
                    </div>
                @endforelse
            </div>
            
            @if($hasMoreItems)
                <div class="mt-6 text-center">
                    <button wire:click="loadMore" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Load More
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
