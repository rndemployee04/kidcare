<x-parent.layouts.parent-layout>
    <div class="px-4 py-8 pb-0 ">
        <a href="http://localhost:8000/parent/dashboard"
            class="block flex items-center text-[18px] text-[#ff8904] font-semibold hover:underline mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Recommendations
        </a>
        <div class="bg-white shadow rounded-lg p-6 w-[48%] float-left">
            <div class="flex flex-col md:flex-row md:items-center gap-6 mb-6">
                <img src="{{ $profile_photo ? asset('storage/' . $profile_photo) : asset('images/profile-placeholder.png') }}"
                    alt="Profile Photo" class="w-28 h-28 rounded-full object-cover border-2 border-blue-400 bg-white">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ (string) ($name ?? 'N/A') }}</h1>
                    <div class="text-sm text-orange-600 font-semibold mb-1">Carebuddy</div>
                    <div class="text-xs text-gray-500">Carebuddy ID: <span
                            class="font-mono">{{ $carebuddy_id ?? 'N/A' }}</span></div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <div class="text-[16px] text-[#00bbae] font-semibold mb-1 uppercase">Contact</div>
                    <div class="flex items-center gap-2 text-sm mb-1"><i class="fa fa-envelope"></i>
                        {{ (string) ($email ?? 'N/A') }}</div>
                    <div class="flex items-center gap-2 text-sm"><i class="fa fa-phone"></i>
                        {{ (string) ($phone ?? 'N/A') }}</div>
                </div>
                <div>
                    <div class="text-[16px] text-[#00bbae] font-semibold mb-1 uppercase">Personal</div>
                    <div class="flex items-center gap-2 text-sm mb-1"><i class="fa fa-venus-mars"></i>
                        {{ (string) ($gender ?? 'N/A') }}</div>
                    <div class="flex items-center gap-2 text-sm"><i class="fa fa-cake-candles"></i>
                        @php $dobValue = isset($dob) ? $dob : (isset($carebuddy_dob) ? $carebuddy_dob : null); @endphp
                        @if (!empty($dobValue))
                            {{ \Carbon\Carbon::parse($dobValue)->format('d M Y') }}
                        @else
                            N/A
                        @endif
                    </div>
                </div>
                <div>
                    <div class="text-[16px] text-[#00bbae] font-semibold mb-1 uppercase">Location</div>
                    <div class="flex items-center gap-2 text-sm mb-1"><i class="fa fa-location-dot"></i>
                        {{ (string) ($current_address ?? 'N/A') }}</div>
                    <div class="flex items-center gap-2 text-sm mb-1"><i class="fa fa-city"></i>
                        {{ (string) ($city ?? 'N/A') }}</div>
                    <div class="flex items-center gap-2 text-sm"><i class="fa fa-map"></i>
                        {{ (string) ($state ?? 'N/A') }}</div>
                </div>
                <div>
                    <div class="text-[16px] text-[#00bbae] font-semibold mb-1 uppercase">Service</div>
                    <div class="flex items-center gap-2 text-sm mb-1"><i class="fa fa-ruler-horizontal"></i> Radius:
                        {{ (string) ($service_radius ?? 'N/A') }}</div>
                    <div class="flex items-center gap-2 text-sm mb-1"><i class="fa fa-child"></i> Age Limit:
                        {{ (string) ($child_age_limit ?? 'N/A') }}</div>
                    <div class="flex items-center gap-2 text-sm"><i class="fa fa-calendar-check"></i> Availability:
                        {{ is_array($availability) ? implode(', ', $availability) : (string) ($availability ?? 'N/A') }}
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <div class="text-[16px] text-[#00bbae] font-semibold mb-1 uppercase">Documents</div>
                    <div class="flex items-center gap-2 text-sm mb-1"><i class="fa fa-id-card"></i> ID Proof:
                        @if (!empty($id_proof_path))
                            <a href="{{ asset('storage/' . $id_proof_path) }}" class="text-orange-500 underline ml-1"
                                target="_blank">View</a>
                        @else
                            <span class="text-gray-400 ml-1">N/A</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2 text-sm"><i class="fa fa-camera"></i> Selfie:
                        @if (!empty($selfie_path))
                            <a href="{{ asset('storage/' . $selfie_path) }}" class="text-orange-500 underline ml-1"
                                target="_blank">View</a>
                        @else
                            <span class="text-gray-400 ml-1">N/A</span>
                        @endif
                    </div>
                </div>
                <div>
                    <div class="text-[16px] text-[#00bbae] font-semibold mb-1 uppercase">Verification</div>
                    <div class="flex items-center gap-2 text-sm mb-1"><i class="fa fa-shield-heart"></i> Insurance:
                        {{ isset($willing_to_take_insurance) ? ($willing_to_take_insurance ? 'Yes' : 'No') : 'N/A' }}
                    </div>
                    <div class="flex items-center gap-2 text-sm mb-1"><i class="fa fa-user-check"></i> Status:
                        @php
                            $status = $user->verification_status ?? 'N/A';
                            $badgeColor = 'bg-gray-400';
                            if ($status === 'approved') {
                                $badgeColor = 'bg-green-500';
                            } elseif ($status === 'pending') {
                                $badgeColor = 'bg-yellow-400';
                            } elseif ($status === 'rejected') {
                                $badgeColor = 'bg-red-500';
                            }
                        @endphp
                        <span class="px-2 py-1 rounded text-white text-xs font-semibold {{ $badgeColor }}">
                            {{ ucfirst($status) }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="flex flex-col md:flex-row gap-4 mt-8">
                @if (isset($alreadyBooked) && $alreadyBooked)
                    <button disabled
                        class="flex-1 bg-gray-400 text-white font-semibold py-3 rounded-lg text-center cursor-not-allowed opacity-70">Already
                        Booked</button>
                @else
                    <a href="/parent/book/{{ $carebuddy_id }}"
                        class="flex-1 bg-[#00bbae] hover:bg-orange-500 text-white font-semibold py-3 rounded-lg transition text-center">Book
                        Slot</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Info Sections -->
    <div class="space-y-6 mb-10 ">
        <!-- Contact Info -->
        <div class="bg-white shadow rounded-lg p-6 w-1/2 float-right">
            <div>
                <div class="mb-0 text-[16px] text-[#00bbae] uppercase font-semibold dark:text-gray-300 flex items-center gap-2 ">
                    <i class="fa-solid fa-address-book"></i> Contact
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="flex items-center gap-2"><i class="fa-solid fa-envelope"></i> <span>Email:</span> <span
                            class="font-semibold">{{ (string) ($email ?? 'N/A') }}</span></div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-phone"></i> <span>Phone:</span> <span
                            class="font-semibold">{{ (string) ($phone ?? 'N/A') }}</span></div>
                </div>
            </div>
            <!-- Personal Info -->
            <div class="py-[14px] px-0">
                <div class="mb-0 text-[16px] text-[#00bbae] uppercase font-semibold dark:text-gray-300 flex items-center gap-2">
                    <i class="fa-solid fa-user"></i> Personal
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
                    <div class="flex items-center gap-2"><i class="fa-solid fa-venus-mars"></i> <span>Gender:</span>
                        <span class="font-semibold">{{ (string) ($gender ?? 'N/A') }}</span>
                    </div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-cake-candles"></i> <span>DOB:</span>
                        <span class="font-semibold">
                            @php $dobValue = isset($dob) ? $dob : (isset($carebuddy_dob) ? $carebuddy_dob : null); @endphp
                            @if (!empty($dobValue))
                                {{ \Carbon\Carbon::parse($dobValue)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-location-dot"></i> <span>Current
                            Address:</span> <span
                            class="font-semibold">{{ (string) ($current_address ?? 'N/A') }}</span></div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-house"></i> <span>Permanent
                            Address:</span> <span
                            class="font-semibold">{{ (string) ($permanent_address ?? 'N/A') }}</span></div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-city"></i> <span>City:</span> <span
                            class="font-semibold">{{ (string) ($city ?? 'N/A') }}</span></div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-map"></i> <span>State:</span> <span
                            class="font-semibold">{{ (string) ($state ?? 'N/A') }}</span></div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-location-crosshairs"></i>
                        <span>Zip:</span> <span class="font-semibold">{{ (string) ($zip ?? 'N/A') }}</span>
                    </div>
                </div>
            </div>
            <!-- Service Details -->
            <div>
                <div class="text-[16px] text-[#00bbae] font-semibold uppercase flex items-center gap-2">
                    <i class="fa-solid fa-briefcase-medical"></i> Service Details
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="flex items-center gap-2"><i class="fa-solid fa-ruler-horizontal"></i> <span>Service
                            Radius:</span> <span
                            class="font-semibold">{{ (string) ($service_radius ?? 'N/A') }}</span></div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-child"></i> <span>Child Age
                            Limit:</span> <span
                            class="font-semibold">{{ (string) ($child_age_limit ?? 'N/A') }}</span></div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-calendar-check"></i>
                        <span>Availability:</span> <span
                            class="font-semibold">{{ is_array($availability) ? implode(', ', $availability) : (string) ($availability ?? 'N/A') }}</span>
                    </div>
                </div>
            </div>
            <!-- Verification & Docs -->
            <div class="py-[14px] px-0">
                <div class="mb-0 text-[16px] text-[#00bbae] uppercase font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved"></i> Verification & Documents
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div class="flex items-center gap-2"><i class="fa-solid fa-file-id-card"></i> <span>ID
                            Proof:</span>
                        @if (!empty($id_proof_path))
                            <a href="{{ asset('storage/' . $id_proof_path) }}" class="text-orange-500 underline"
                                target="_blank">View</a>
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-camera"></i> <span>Selfie:</span>
                        @if (!empty($selfie_path))
                            <a href="{{ asset('storage/' . $selfie_path) }}" class="text-orange-500 underline"
                                target="_blank">View</a>
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-shield-heart"></i>
                        <span>Insurance:</span> <span
                            class="font-semibold">{{ isset($willing_to_take_insurance) ? ($willing_to_take_insurance ? 'Yes' : 'No') : 'N/A' }}</span>
                    </div>
                    <div class="flex items-center gap-2"><i class="fa-solid fa-user-check"></i>
                        <span>Verification:</span> <span
                            class="font-semibold">{{ (string) ($verification_status ?? 'N/A') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mt-8 clear-both pt-8">
        @if (isset($alreadyBooked) && $alreadyBooked)
            <button disabled
                class="flex-1 bg-gray-400 text-white font-semibold py-3 rounded-lg text-center cursor-not-allowed opacity-70">Already
                Booked</button>
        @else
            <a href="/parent/book/{{ $carebuddy_id }}"
                class="flex-1 bg-orange-400 hover:bg-[#00bbae] text-white font-semibold py-3 rounded-lg transition text-center">Book
                Slot</a>
        @endif
        <a href="/parent/dashboard"
            class="flex-1 bg-[#00bbae] hover:bg-orange-400 dark:bg-neutral-700 dark:hover:bg-neutral-600 text-white dark:text-gray-100 font-semibold py-3 rounded-lg transition text-center">Back
            to Recommendations</a>
    </div>
</x-parent.layouts.parent-layout>

{{-- <!-- Info Sections -->
            <div class="space-y-6 mb-10">
                <!-- Contact Info -->
                <div>
                    <div class="mb-2 text-sm font-bold text-gray-600 dark:text-gray-300 flex items-center gap-2">
                        <i class="fa-solid fa-address-book"></i> Contact
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-envelope"></i> <span>Email:</span> <span class="font-semibold">{{ (string) ($email ?? 'N/A') }}</span></div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-phone"></i> <span>Phone:</span> <span class="font-semibold">{{ (string) ($phone ?? 'N/A') }}</span></div>
                    </div>
                </div>
                <!-- Personal Info -->
                <div>
                    <div class="mb-2 text-sm font-bold text-gray-600 dark:text-gray-300 flex items-center gap-2">
                        <i class="fa-solid fa-user"></i> Personal
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-venus-mars"></i> <span>Gender:</span> <span class="font-semibold">{{ (string) ($gender ?? 'N/A') }}</span></div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-cake-candles"></i> <span>DOB:</span> <span class="font-semibold">
                            @php $dobValue = isset($dob) ? $dob : (isset($carebuddy_dob) ? $carebuddy_dob : null); @endphp
                            @if (!empty($dobValue))
                                {{ \Carbon\Carbon::parse($dobValue)->format('d M Y') }}
                            @else
                                N/A
                            @endif
                        </span></div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-location-dot"></i> <span>Current Address:</span> <span class="font-semibold">{{ (string) ($current_address ?? 'N/A') }}</span></div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-house"></i> <span>Permanent Address:</span> <span class="font-semibold">{{ (string) ($permanent_address ?? 'N/A') }}</span></div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-city"></i> <span>City:</span> <span class="font-semibold">{{ (string) ($city ?? 'N/A') }}</span></div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-map"></i> <span>State:</span> <span class="font-semibold">{{ (string) ($state ?? 'N/A') }}</span></div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-location-crosshairs"></i> <span>Zip:</span> <span class="font-semibold">{{ (string) ($zip ?? 'N/A') }}</span></div>
                    </div>
                </div>
                <!-- Service Details -->
                <div>
                    <div class="mb-2 text-sm font-bold text-gray-600 dark:text-gray-300 flex items-center gap-2">
                        <i class="fa-solid fa-briefcase-medical"></i> Service Details
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-ruler-horizontal"></i> <span>Service Radius:</span> <span class="font-semibold">{{ (string) ($service_radius ?? 'N/A') }}</span></div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-child"></i> <span>Child Age Limit:</span> <span class="font-semibold">{{ (string) ($child_age_limit ?? 'N/A') }}</span></div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-calendar-check"></i> <span>Availability:</span> <span class="font-semibold">{{ is_array($availability) ? implode(', ', $availability) : (string) ($availability ?? 'N/A') }}</span></div>
                    </div>
                </div>
                <!-- Verification & Docs -->
                <div>
                    <div class="mb-2 text-sm font-bold text-gray-600 dark:text-gray-300 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved"></i> Verification & Documents
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="flex items-center gap-2"><i class="fa-solid fa-file-id-card"></i> <span>ID Proof:</span>
                            @if (!empty($id_proof_path))
                                <a href="{{ asset('storage/' . $id_proof_path) }}" class="text-blue-500 underline" target="_blank">View</a>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-camera"></i> <span>Selfie:</span>
                            @if (!empty($selfie_path))
                                <a href="{{ asset('storage/' . $selfie_path) }}" class="text-blue-500 underline" target="_blank">View</a>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-shield-heart"></i> <span>Insurance:</span> <span class="font-semibold">{{ isset($willing_to_take_insurance) ? ($willing_to_take_insurance ? 'Yes' : 'No') : 'N/A' }}</span></div>
                        <div class="flex items-center gap-2"><i class="fa-solid fa-user-check"></i> <span>Verification:</span> <span class="font-semibold">{{ (string) ($verification_status ?? 'N/A') }}</span></div>
                    </div>
                </div>
            </div> --}}

<!-- Action Buttons -->

</div>
</div>
</body>

</html>
