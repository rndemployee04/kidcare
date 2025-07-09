<div class="w-full flex flex-col items-left">
    <div class="bg-white/95 rounded-2xl shadow-lg px-6 py-4 mb-8">
        <div class="flex flex-col gap-3 md:flex-row md:gap-4 md:items-center md:justify-between">
            <div class="flex flex-wrap gap-2 flex-1 items-center">
                <input type="text" wire:model.debounce.500ms="search"
                    class="flex-1 min-w-[160px] max-w-[200px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Search by name, city, profession...">
                <select wire:model="location" class="px-3 py-2 border rounded-lg min-w-[120px]">
                    <option value="">All Locations</option>
                    @foreach ($parents->pluck('city')->unique()->filter()->sort() as $city)
                        <option value="{{ $city }}">{{ $city }}</option>
                    @endforeach
                </select>
                <select wire:model="gender" class="px-3 py-2 border rounded-lg min-w-[110px]">
                    <option value="any">Any Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="others">Others</option>
                </select>
                <select wire:model="age_range" class="px-3 py-2 border rounded-lg min-w-[110px]">
                    <option value="any">Any Age</option>
                    <option value="18-25">18-25</option>
                    <option value="26-35">26-35</option>
                    <option value="36-45">36-45</option>
                    <option value="46+">46+</option>
                </select>
                <select wire:model="number_of_children" class="px-3 py-2 border rounded-lg min-w-[110px]">
                    <option value="any">Any Children</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                <select wire:model="children_needing each_care" class="px-3 py-2 border rounded-lg min-w-[110px]">
                    <option value="any">Any Needing Care</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                <select wire:model="caregiver_type" class="px-3 py-2 border rounded-lg min-w-[120px]">
                    <option value="any">Any Caregiver Type</option>
                    <option value="newlywed">Newlywed</option>
                    <option value="professional">Professional</option>
                    <option value="parent">Parent</option>
                    <option value="senior">Senior</option>
                </select>
                <select wire:model="preferred_radius" class="px-3 py-2 border rounded-lg min-w-[110px]">
                    <option value="any">Any Radius</option>
                    <option value="2-3">2-3 km</option>
                    <option value="3-4">3-4 km</option>
                    <option value="4-5">4-5 km</option>
                </select>
                <div class="flex flex-row gap-2 items-center ml-2">
                    <span class="text-xs font-semibold">Drop-off Time:</span>
                    @foreach (['morning', 'afternoon', 'evening', 'full_day'] as $slot)
                        <label class="inline-flex items-center text-xs gap-1">
                            <input type="checkbox" wire:model="drop_off_time" value="{{ $slot }}"
                                class="rounded border-gray-300">
                            {{ ucfirst(str_replace('_', ' ', $slot)) }}
                        </label>
                    @endforeach
                </div>
                <label class="inline-flex items-center text-xs gap-1 ml-2">
                    <input type="checkbox" wire:model="special_needs_support" class="rounded border-gray-300">
                    Special Needs Support
                </label>
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

    <div id="parent-list">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($parents as $parent)
                <div
                    class="rounded-3xl shadow-lg flex flex-col items-center p-7 text-center min-h-[420px] transition-colors bg-gray-50 dark:bg-gray-800 dark:text-gray-100 border border-gray-200 dark:border-gray-700">
                    <div class="mb-5 flex flex-col items-center">
                        @if ($parent->profile_photo)
                            <img src="{{ asset('storage/' . $parent->profile_photo) }}" alt="Profile Photo"
                                class="w-24 h-24 rounded-full object-cover border-4 border-blue-400 dark:border-blue-500 shadow-md bg-white dark:bg-gray-700">
                        @else
                            <div
                                class="w-24 h-24 rounded-full flex items-center justify-center border-4 border-gray-300 dark:border-gray-600 shadow-md bg-gradient-to-br from-gray-200 via-gray-100 to-gray-300 dark:from-gray-700 dark:via-gray-800 dark:to-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 64 64"
                                    stroke="currentColor" class="w-16 h-16 text-gray-400 dark:text-gray-500">
                                    <circle cx="32" cy="24" r="14" stroke-width="3" />
                                    <path stroke-width="3" d="M10 54c0-8 10-14 22-14s22 6 22 14" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="font-extrabold text-xl mb-2 tracking-tight">{{ $parent->user->name ?? 'N/A' }}</div>
                    <div class="text-gray-500 dark:text-gray-400 text-sm mb-3 flex items-center justify-center gap-1">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $parent->city ?? '-' }}
                    </div>
                    <div class="flex flex-wrap justify-center gap-2 mb-3">
                        <span
                            class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-200 rounded-full text-xs flex items-center gap-1">
                            <i class="fa-solid fa-user"></i>
                            Age: {{ $parent->dob ? \Carbon\Carbon::parse($parent->dob)->age : '-' }}
                        </span>
                        <span
                            class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-200 rounded-full text-xs flex items-center gap-1">
                            <i class="fa-solid fa-child"></i>
                            Children: {{ $parent->number_of_children ?? '-' }}
                        </span>
                        <span
                            class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-full text-xs flex items-center gap-1">
                            <i class="fa-solid fa-child-reaching"></i>
                            Needing Care: {{ $parent->number_needing_care ?? '-' }}
                        </span>
                    </div>
                    <div class="flex flex-wrap justify-center gap-2 mb-3">
                        <span
                            class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200 rounded-full text-xs flex items-center gap-1">
                            <i class="fa-solid fa-ruler-horizontal"></i>
                            Radius: {{ $parent->preferred_radius ?? '-' }} km
                        </span>
                        <span
                            class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-200 rounded-full text-xs flex items-center gap-1">
                            <i class="fa-solid fa-user-group"></i>
                            Caregiver: {{ $parent->preferred_type_of_caregiver ?? '-' }}
                        </span>
                    </div>
                    <div class="w-full border-t border-gray-200 dark:border-gray-700 my-4"></div>
                    <div class="mb-4 w-full">
                        <div class="flex flex-col mb-2">
                            <div class="flex items-center justify-start">
                                <span
                                    class="inline-flex items-center px-2 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-full text-xs">
                                    <i class="fa-solid fa-calendar-check mr-1"></i>
                                    {{ is_array($parent->preferred_drop_off_time) ? implode(', ', $parent->preferred_drop_off_time) : $parent->preferred_drop_off_time ?? '-' }}
                                </span>

                                @if ($parent->needs_special_needs_support)
                                    <span
                                        class="inline-flex items-center px-2 py-1 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-full text-xs ml-2">
                                        <i class="fa-solid fa-heart mr-1"></i>
                                        Special Needs
                                    </span>
                                @endif
                            </div>

                            @if ($parent->needs_special_needs_support && $parent->reason_for_service)
                                <div class="mt-2 text-sm text-gray-800 dark:text-gray-200">
                                    <strong>Reason for Special Needs Support:</strong>
                                    <div>{{ $parent->reason_for_service }}</div>
                                </div>
                            @endif
                            
                            @if ($parent->children && $parent->children->count() > 0)
                                <button wire:click="viewChildren({{ $parent->id }})"
                                    class="w-full mt-2 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 rounded-lg transition">
                                    View Children
                                </button>
                            @endif
                        </div>

                    </div>
                    <div class="mt-auto w-full flex gap-2">
                        <a href="{{ route('parent.playpal.profile', $parent->id) }}"
                            class="w-1/2 bg-orange-400 hover:bg-[#00bbae] text-white font-semibold py-2 rounded-lg transition">View
                            Profile</a>
                        @if (isset($bookedParentIds) && in_array($parent->id, $bookedParentIds))
                            <button
                                class="w-1/2 bg-gray-400 text-white font-semibold py-2 rounded-lg cursor-not-allowed"
                                disabled>Booked</button>
                        @else
                            <a href="/playpal/book/{{ $parent->id }}"
                                class="w-1/2 bg-[#00bbae] hover:bg-orange-500 text-white font-semibold py-2 rounded-lg transition">Book</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500">No parents found.</div>
            @endforelse
        </div>
        <div class="flex justify-center mt-6">
            {{ $parents->links() }}
        </div>
    </div>


    @if ($showChildrenModal)
        <div class="fixed inset-0 bg-transparent backdrop-blur-md bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white dark:bg-gray-900 rounded-xl p-6 w-full max-w-2xl shadow-lg relative">
                <button wire:click="closeChildrenModal"
                    class="absolute top-2 right-2 text-gray-600 hover:text-red-600">
                    ✕
                </button>

                <h3 class="text-lg font-semibold mb-4">Children of {{ $selectedParent->user->name ?? 'Parent' }}</h3>

                @if (count($children))
                    <div class="space-y-4 max-h-[400px] overflow-y-auto">
                        @foreach ($children as $child)
                            <div
                                class="flex items-start gap-6 p-6 bg-white dark:bg-gray-900 rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
                                <!-- Image Section -->
                                <div class="flex-shrink-0">
                                    <div
                                        class="w-28 h-28 rounded-full overflow-hidden border-4 border-blue-500 bg-white flex items-center justify-center text-center text-gray-500 text-xs">
                                        @if ($child->photo)
                                            <img src="{{ asset('storage/' . $child->photo) }}"
                                                alt="{{ $child->full_name }}" class="w-full h-full object-cover">
                                        @else
                                            <span>NO IMAGE<br>AVAILABLE</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Info Section -->
                                <div
                                    class="flex-1 grid grid-cols-2 gap-x-6 gap-y-3 text-sm text-gray-700 dark:text-gray-200">
                                    <div><span class="font-semibold">Name:</span> {{ $child->full_name }}</div>
                                    <div><span class="font-semibold">DOB:</span>
                                        {{ $child->dob ? \Carbon\Carbon::parse($child->dob)->format('d M Y') : '-' }}
                                    </div>
                                    <div><span class="font-semibold">Gender:</span> {{ ucfirst($child->gender) }}
                                    </div>
                                    <div><span class="font-semibold">Hobbies:</span> {{ $child->hobbies ?? '-' }}
                                    </div>
                                    <div><span class="font-semibold">Allergies:</span>
                                        {{ is_array($child->allergies) ? implode(', ', $child->allergies) : $child->allergies ?? '-' }}
                                    </div>
                                    <div><span class="font-semibold">Diseases:</span>
                                        {{ is_array($child->diseases) ? implode(', ', $child->diseases) : $child->diseases ?? '-' }}
                                    </div>
                                    <div><span class="font-semibold">Disabilities:</span>
                                        {{ is_array($child->disabilities) ? implode(', ', $child->disabilities) : $child->disabilities ?? '-' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-gray-500">No children added by this parent.</div>
                @endif

            </div>
        </div>
    @endif

</div>
