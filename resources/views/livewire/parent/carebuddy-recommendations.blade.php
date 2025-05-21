<div>
    <h2 class="mb-4">Recommended Carebuddies</h2>
    <div class="mb-3">
        <input type="text" wire:model.debounce.500ms="search"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Search by name...">
    </div>
    <div id="carebuddy-list">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @forelse($carebuddies as $carebuddy)
                <div
                    class="rounded-3xl shadow-lg flex flex-col items-center p-7 text-center min-h-[420px] transition-colors bg-gray-50 dark:bg-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-700">
                    <div class="mb-5 flex flex-col items-center">
                        @if($carebuddy->profile_photo)
                            <img src="{{ asset('storage/' . $carebuddy->profile_photo) }}" alt="Profile Photo"
                                class="w-24 h-24 rounded-full object-cover border-4 border-blue-400 dark:border-blue-500 shadow-md bg-white dark:bg-gray-700">
                        @else
                            <div
                                class="w-24 h-24 rounded-full flex items-center justify-center border-4 border-gray-300 dark:border-gray-600 shadow-md bg-gradient-to-br from-gray-200 via-gray-100 to-gray-300 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 64 64" stroke="currentColor"
                                    class="w-16 h-16 text-gray-400 dark:text-gray-500">
                                    <circle cx="32" cy="24" r="14" stroke-width="3" />
                                    <path stroke-width="3" d="M10 54c0-8 10-14 22-14s22 6 22 14" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="font-extrabold text-xl mb-2 tracking-tight">{{ $carebuddy->user->name ?? 'N/A' }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm mb-3 flex items-center justify-center gap-1">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $carebuddy->city ?? '-' }}
                    </div>
                    <div class="flex flex-wrap justify-center gap-2 mb-3">
                        <span
                            class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-full text-xs flex items-center gap-1">
                            <i class="fa-solid fa-ruler-horizontal"></i>
                            Radius: {{ $carebuddy->service_radius }} km
                        </span>
                        <span
                            class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-200 rounded-full text-xs flex items-center gap-1">
                            <i class="fa-solid fa-child"></i>
                            Age: {{ $carebuddy->child_age_limit }}
                        </span>
                    </div>
                    <div class="w-full border-t border-gray-200 dark:border-gray-700 my-4"></div>
                    <div class="mb-4 w-full">
                        <div class="flex items-center justify-center mb-2">
                            <span
                                class="inline-flex items-center px-2 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-full text-xs">
                                <i class="fa-solid fa-calendar-check mr-1"></i>
                                {{ is_array($carebuddy->availability) ? implode(', ', $carebuddy->availability) : $carebuddy->availability }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-auto w-full flex gap-2">
                        <a href="/parent/carebuddy/{{ $carebuddy->id }}"
                            class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">View
                            Profile</a>
                        @if(isset($bookedCarebuddies) && in_array($carebuddy->id, $bookedCarebuddies))
                            <button class="w-1/2 bg-gray-400 text-white font-semibold py-2 rounded-lg cursor-not-allowed" disabled>Booked</button>
                        @else
                            <a href="/parent/book/{{ $carebuddy->id }}"
                                class="w-1/2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 rounded-lg transition">Book</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500">No carebuddies found.</div>
            @endforelse
        </div>
        <div class="flex justify-center mt-6">
            {{ $carebuddies->links() }}
        </div>
    </div>
</div>