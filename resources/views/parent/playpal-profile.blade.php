<x-parent.layouts.parent-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 pb-0 bg-gray-50">
        <a href="{{ route('playpal.dashboard') }}"
            class="block flex items-center text-[18px] text-[#ff8904] font-semibold hover:underline mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Dashboard
        </a>
        <div class="bg-white shadow rounded-lg p-6 w-full max-w-2xl">
            <div class="flex flex-col md:flex-row md:items-center gap-6 mb-6">
                <img src="{{ $profile_photo ? asset('storage/' . $profile_photo) : asset('images/profile-placeholder.png') }}"
                    alt="Profile Photo" class="w-28 h-28 rounded-full object-cover border-2 border-blue-400 bg-white">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ (string) ($name ?? 'N/A') }}</h1>
                    <div class="text-sm text-orange-600 font-semibold mb-1">Playpal</div>
                    <div class="text-xs text-gray-500">Playpal ID: <span
                            class="font-mono">{{ $playpal_id ?? 'N/A' }}</span></div>
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
                        @php $dobValue = isset($dob) ? $dob : (isset($playpal_dob) ? $playpal_dob : null); @endphp
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
                    <a href="/playpal/book/{{ $playpal_id }}"
                        class="flex-1 bg-[#00bbae] hover:bg-orange-500 text-white font-semibold py-3 rounded-lg transition text-center">Book
                        Slot</a>
                @endif
            </div>
        </div>
    </div>
</x-parent.layouts.parent-layout>