<x-layouts.app>
    <div class="flex justify-center items-center min-h-[80vh] bg-gray-100 dark:bg-neutral-900 py-8">
        <div class="rounded-3xl shadow-lg bg-white dark:bg-neutral-800 dark:text-gray-100 max-w-2xl w-full p-8">
            <div class="flex flex-col items-center mb-8">
                <img src="{{ $profile_photo ? asset('storage/' . $profile_photo) : asset('images/profile-placeholder.png') }}"
                    alt="Profile Photo"
                    class="w-32 h-32 rounded-full object-cover border-4 border-blue-400 dark:border-blue-500 shadow mb-3 bg-white dark:bg-neutral-700">
                <h2 class="font-extrabold text-3xl mb-1 text-center">{{ (string) ($name ?? 'N/A') }}</h2>
                <div class="text-gray-500 dark:text-gray-300 mb-1">{{ (string) ($category ?? 'N/A') }}</div>
                <div class="text-sm text-gray-400 dark:text-gray-400">Carebuddy ID: <span
                        class="font-mono">{{ $carebuddy_id ?? 'N/A' }}</span></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-envelope"></i>
                    <span class="font-medium">Email:</span> <span>{{ (string) ($email ?? 'N/A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-phone"></i>
                    <span class="font-medium">Phone:</span> <span>{{ (string) ($phone ?? 'N/A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-venus-mars"></i>
                    <span class="font-medium">Gender:</span> <span>{{ (string) ($gender ?? 'N/A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-cake-candles"></i>
                    <span class="font-medium">DOB:</span>
                    <span>
                        @php $dobValue = isset($dob) ? $dob : (isset($carebuddy_dob) ? $carebuddy_dob : null); @endphp
                        @if(!empty($dobValue))
                            {{ \Carbon\Carbon::parse($dobValue)->format('d M Y') }}
                        @else
                            N/A
                        @endif
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-location-dot"></i>
                    <span class="font-medium">Current Address:</span>
                    <span>{{ (string) ($current_address ?? 'N/A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-house"></i>
                    <span class="font-medium">Permanent Address:</span>
                    <span>{{ (string) ($permanent_address ?? 'N/A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-city"></i>
                    <span class="font-medium">City:</span> <span>{{ (string) ($city ?? 'N/A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-map"></i>
                    <span class="font-medium">State:</span> <span>{{ (string) ($state ?? 'N/A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-location-crosshairs"></i>
                    <span class="font-medium">Zip:</span> <span>{{ (string) ($zip ?? 'N/A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-ruler-horizontal"></i>
                    <span class="font-medium">Service Radius:</span>
                    <span>{{ (string) ($service_radius ?? 'N/A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-child"></i>
                    <span class="font-medium">Child Age Limit:</span>
                    <span>{{ (string) ($child_age_limit ?? 'N/A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-calendar-check"></i>
                    <span class="font-medium">Availability:</span>
                    <span>{{ is_array($availability) ? implode(', ', $availability) : (string) ($availability ?? 'N/A') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-file-id-card"></i>
                    <span class="font-medium">ID Proof:</span>
                    @if(!empty($id_proof_path))
                        <a href="{{ asset('storage/' . $id_proof_path) }}" class="text-blue-500 underline"
                            target="_blank">View</a>
                    @else
                        <span class="text-gray-400">N/A</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-camera"></i>
                    <span class="font-medium">Selfie:</span>
                    @if(!empty($selfie_path))
                        <a href="{{ asset('storage/' . $selfie_path) }}" class="text-blue-500 underline"
                            target="_blank">View</a>
                    @else
                        <span class="text-gray-400">N/A</span>
                    @endif
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-shield-heart"></i>
                    <span class="font-medium">Willing to Take Insurance:</span>
                    <span>{{ isset($willing_to_take_insurance) ? ($willing_to_take_insurance ? 'Yes' : 'No') : 'N/A' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-user-check"></i>
                    <span class="font-medium">Verification Status:</span>
                    <span>{{ (string) ($verification_status ?? 'N/A') }}</span>
                </div>
            </div>

            <div class="flex gap-4">
                <a href="/parent/book/{{ $carebuddy_id }}"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition text-center">Book
                    Slot</a>
                <a href="/parent/dashboard"
                    class="flex-1 bg-gray-300 hover:bg-gray-400 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-gray-800 dark:text-gray-100 font-semibold py-2 rounded-lg transition text-center">Back
                    to Recommendations</a>
            </div>
        </div>
    </div>
</x-layouts.app>