<div class="w-full flex flex-col items-left">
    <div class="bg-white/95 rounded-2xl shadow-lg px-6 py-4 mb-8">
        <div class="flex flex-col gap-3 md:flex-row md:gap-4 md:items-center md:justify-between">
            <div class="flex flex-wrap gap-2 flex-1 items-center">
                <input type="text" wire:model.debounce.500ms="search"
                    class="flex-1 min-w-[160px] max-w-[200px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Search by name, city, etc...">
                <select wire:model="location" class="px-3 py-2 border rounded-lg min-w-[120px]">
                    <option value="">All Locations</option>
                    @foreach($playpals->pluck('city')->unique()->filter()->sort() as $city)
                        <option value="{{ $city }}">{{ $city }}</option>
                    @endforeach
                </select>
                <select wire:model="radius" class="px-3 py-2 border rounded-lg min-w-[110px]">
                    <option value="">Any Radius</option>
                    <option value="2-3">2-3 km</option>
                    <option value="3-4">3-4 km</option>
                    <option value="4-5">4-5 km</option>
                </select>
                <select wire:model="child_age" class="px-3 py-2 border rounded-lg min-w-[100px]">
                    <option value="">Any Age</option>
                    <option value="2-3">2-3</option>
                    <option value="3-5">3-5</option>
                    <option value="5-8">5-8</option>
                    <option value="8-10">8-10</option>
                    <option value="all">All</option>
                </select>
                <select wire:model="category" class="px-3 py-2 border rounded-lg min-w-[120px]">
                    <option value="any">Any Category</option>
                    <option value="newlywed">Newlywed</option>
                    <option value="professional">Professional</option>
                    <option value="parent">Parent</option>
                    <option value="senior">Senior</option>
                </select>
                <select wire:model="gender" class="px-3 py-2 border rounded-lg min-w-[110px]">
                    <option value="any">Any Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="others">Others</option>
                </select>
                <div class="flex flex-row gap-2 items-center ml-2">
                    <span class="text-xs font-semibold">Availability:</span>
                    @foreach(['morning', 'afternoon', 'evening', 'full_day'] as $slot)
                        <label class="inline-flex items-center text-xs gap-1">
                            <input type="checkbox" wire:model="availability" value="{{ $slot }}"
                                class="rounded border-gray-300">
                            {{ ucfirst(str_replace('_', ' ', $slot)) }}
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="flex flex-row gap-2 md:ml-4 justify-end">
                <button type="button" wire:click="applyFilters"
                    class="px-4 py-2 bg-orange-400 text-white rounded-lg font-semibold hover:bg-[#00bbae] transition">Apply
                    Filters</button>
                <button type="button" wire:click="clearFilters"
                    class="px-4 py-2 bg-[#00bbae] text-white rounded-lg font-semibold hover:bg-orange-500 transition">Clear
                    All</button>
            </div>
        </div>
    </div>

    <div id="playpal-list">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($playpals as $playpal)
                <div
                    class="rounded-3xl shadow-lg flex flex-col items-center p-7 text-center min-h-[420px] transition-colors bg-gray-50 dark:bg-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-700">
                    <div class="mb-5 flex flex-col items-center">
                        @if($playpal->profile_photo)
                            <img src="{{ asset('storage/' . $playpal->profile_photo) }}" alt="Profile Photo"
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
                    <div class="font-extrabold text-xl mb-2 tracking-tight">{{ $playpal->user->name ?? 'N/A' }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm mb-3 flex items-center justify-center gap-1">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $playpal->city ?? '-' }}
                    </div>
                    <div class="flex flex-wrap justify-center gap-2 mb-3">
                        <span
                            class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-full text-xs flex items-center gap-1">
                            <i class="fa-solid fa-ruler-horizontal"></i>
                            Radius: {{ $playpal->service_radius }} km
                        </span>
                        <span
                            class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-200 rounded-full text-xs flex items-center gap-1">
                            <i class="fa-solid fa-child"></i>
                            Age: {{ $playpal->child_age_limit }}
                        </span>
                    </div>
                    <div class="w-full border-t border-gray-200 dark:border-gray-700 my-4"></div>
                    <div class="mb-4 w-full">
                        <div class="flex items-center justify-center mb-2">
                            <span
                                class="inline-flex items-center px-2 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-full text-xs">
                                <i class="fa-solid fa-calendar-check mr-1"></i>
                                {{ is_array($playpal->availability) ? implode(', ', $playpal->availability) : $playpal->availability }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-auto w-full flex gap-2">
                        <a href="/parent/playpal/{{ $playpal->id }}"
                            class="w-1/2 bg-orange-400 hover:bg-[#00bbae] text-white font-semibold py-2 rounded-lg transition">View
                            Profile</a>
                        @if(isset($bookedPlaypalIds) && in_array($playpal->id, $bookedPlaypalIds))
                            <button class="w-1/2 bg-gray-400 text-white font-semibold py-2 rounded-lg cursor-not-allowed"
                                disabled>Booked</button>
                        @else
                            <a href="/parent/book/{{ $playpal->id }}"
                                class="w-1/2 bg-[#00bbae] hover:bg-orange-500 text-white font-semibold py-2 rounded-lg transition">Book</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500">No PlayPals found.</div>
            @endforelse
        </div>
        <div class="flex justify-center mt-6">
            {{ $playpals->links() }}
        </div>
    </div>
</div>