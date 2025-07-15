<x-playpal.layouts.playpal>
    <div class="container mx-auto py-8">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Booking Details</h2>
                <a href="{{ route('playpal.bookings') }}" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-5 h-5 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l3-3a1 1 0 00-1.414-1.414l-3 3a1 1 0 001.414 1.414L9 9.586l3.293 3.293a1 1 0 001.414-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Bookings
                </a>
            </div>

            <div class="space-y-8">
                <!-- Booking Summary -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Booking Summary</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-600 mb-1">Booking Status</p>
                            <div class="flex items-center">
                                @if($booking->status === 'accepted')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Accepted
                                    </span>
                                @elseif($booking->status === 'confirmed')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Confirmed
                                    </span>
                                    </span>
                                @elseif($booking->status === 'rejected')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @elseif($booking->status === 'completed')
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                @else
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                        Pending
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Amount</p>
                            <span class="text-xl font-bold">${{ $booking->amount }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Payment Date</p>
                            <span>{{ $booking->paid_at ? $booking->paid_at->format('F j, Y') : '-' }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Payment Time</p>
                            <span>{{ $booking->paid_at ? $booking->paid_at->format('g:i A') : '-' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Parent Details -->
                
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Parent Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <p class="text-gray-600 mb-1">Name</p>
                            <span class="font-medium">{{ $booking->parent->user->name }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Email</p>
                            <span class="font-medium">{{ $booking->parent->user->email }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Phone</p>
                            <span class="font-medium">{{ $booking->parent->phone }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Gender</p>
                            <span class="font-medium">{{ ucfirst($booking->parent->gender ?? 'N/A') }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Date of Birth</p>
                            <span
                                class="font-medium">{{ $booking->parent->dob ? \Carbon\Carbon::parse($booking->parent->dob)->format('d M Y') : 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Profession</p>
                            <span class="font-medium">{{ $booking->parent->profession ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Number of Children</p>
                            <span class="font-medium">{{ $booking->parent->number_of_children ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Children Needing Care</p>
                            <span class="font-medium">{{ $booking->parent->number_needing_care ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Preferred Drop-off Time</p>
                            <span class="font-medium">
                                {{ $booking->parent->preferred_drop_off_time ?? 'N/A' }}
                            </span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Caregiver Preference</p>
                            <span
                                class="font-medium">{{ $booking->parent->preferred_type_of_caregiver ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Preferred Radius (km)</p>
                            <span class="font-medium">{{ $booking->parent->preferred_radius ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Special Needs Support</p>
                            <span
                                class="font-medium">{{ $booking->parent->needs_special_needs_support ? 'Yes' : 'No' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Reason for Service</p>
                            <span class="font-medium">{{ $booking->parent->reason_for_service ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Emergency Contact Name</p>
                            <span class="font-medium">{{ $booking->parent->emergency_contact_name ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Emergency Contact Phone</p>
                            <span class="font-medium">{{ $booking->parent->emergency_contact_phone ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Spouse Name</p>
                            <span class="font-medium">{{ $booking->parent->spouse_name ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Spouse Email</p>
                            <span class="font-medium">{{ $booking->parent->spouse_email ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Spouse Phone</p>
                            <span class="font-medium">{{ $booking->parent->spouse_phone ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Spouse Profession</p>
                            <span class="font-medium">{{ $booking->parent->spouse_profession ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Monthly Income</p>
                            <span class="font-medium">${{ $booking->parent->monthly_income ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Permanent Address</p>
                            <span class="font-medium">{{ $booking->parent->permanent_address ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Current Address</p>
                            <span class="font-medium">{{ $booking->parent->current_address ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">City</p>
                            <span class="font-medium">{{ $booking->parent->city ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">State</p>
                            <span class="font-medium">{{ $booking->parent->state ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">ZIP</p>
                            <span class="font-medium">{{ $booking->parent->zip ?? 'N/A' }}</span>
                        </div>

                        <div>
                            <p class="text-gray-600 mb-1">Terms Accepted</p>
                            <span class="font-medium">{{ $booking->parent->terms_accepted ? 'Yes' : 'No' }}</span>
                        </div>

                        @if($booking->parent->profile_photo)
                            <div class="col-span-2">
                                <p class="text-gray-600 mb-1">Profile Photo</p>
                                <img src="{{ asset('storage/' . $booking->parent->profile_photo) }}"
                                    alt="{{ $booking->parent->user->name }}'s profile photo"
                                    class="w-48 h-48 rounded-lg object-cover">
                            </div>
                        @endif

                        @if($booking->parent->id_proof_path)
                            <div class="col-span-2">
                                <p class="text-gray-600 mb-1">ID Proof</p>
                                <a href="{{ asset('storage/' . $booking->parent->id_proof_path) }}" target="_blank"
                                    class="text-blue-600 hover:underline">
                                    View ID Proof
                                </a>
                            </div>
                        @endif

                    </div>
                </div>


                <!-- Booking Timeline -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Booking Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <span
                                    class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-blue-100 text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Booking Created</p>
                                <p class="text-sm text-gray-500">{{ $booking->created_at->format('F j, Y g:i A') }}</p>
                            </div>
                        </div>
                        @if($booking->paid_at)
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-100 text-green-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 11-16 0 3 3 0 0116 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Payment Made</p>
                                    <p class="text-sm text-gray-500">{{ $booking->paid_at->format('F j, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($booking->carebuddy_accepted)
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-yellow-100 text-yellow-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Accepted by
                                        {{ $booking->parent->user->name }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $booking->accepted_at->format('F j, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($booking->status === 'completed')
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-green-100 text-green-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Session Completed</p>
                                    <p class="text-sm text-gray-500">{{ $booking->updated_at->format('F j, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                        @if($booking->status === 'rejected')
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-red-100 text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Rejected by
                                        {{ $booking->parent->user->name }}
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $booking->updated_at->format('F j, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-playpal.layouts.playpal>