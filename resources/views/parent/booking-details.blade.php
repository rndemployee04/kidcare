<x-parent.layouts.parent-layout>

    <div class="container mx-auto py-8">
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Booking Details</h2>
                <a href="{{ route('parent.bookings') }}" class="text-blue-600 hover:text-blue-800">
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
                            @if(!$booking->paid_at)
                                <div class="mt-2">
                                    <div id="paypal-button-container"></div>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Payment Date</p>
                            <span>{{ $booking->paid_at ? $booking->paid_at->format('F j, Y') : 'Not paid yet' }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Payment Method</p>
                            <span>{{ $booking->paid_at ? 'PayPal' : '-' }}</span>
                        </div>
                        @if($booking->carebuddy_accepted)
                            <div>
                                <p class="text-gray-600 mb-1">Earnings</p>
                                <span class="text-xl font-bold">${{ $booking->carebuddy_earnings }}</span>
                            </div>
                            <div>
                                <p class="text-gray-600 mb-1">Platform Fee</p>
                                <span class="text-xl font-bold">${{ $booking->platform_fee }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Playpal Details -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Playpal Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-gray-600 mb-1">Name</p>
                            <span class="font-medium">{{ $booking->playpal->user->name }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Email</p>
                            <span class="font-medium">{{ $booking->playpal->user->email }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Phone</p>
                            <span class="font-medium">{{ $booking->playpal->phone }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Gender</p>
                            <span class="font-medium">{{ ucfirst($booking->playpal->gender) }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Date of Birth</p>
                            <span
                                class="font-medium">{{ \Carbon\Carbon::parse($booking->playpal->dob)->format('F j, Y') }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">City</p>
                            <span class="font-medium">{{ $booking->playpal->city }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">State</p>
                            <span class="font-medium">{{ $booking->playpal->state }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Zip Code</p>
                            <span class="font-medium">{{ $booking->playpal->zip }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Permanent Address</p>
                            <span class="font-medium">{{ $booking->playpal->permanent_address }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Current Address</p>
                            <span class="font-medium">{{ $booking->playpal->current_address }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Service Radius</p>
                            <span class="font-medium">{{ $booking->playpal->service_radius }} km</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Child Age Limit</p>
                            <span class="font-medium">{{ $booking->playpal->child_age_limit }}</span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Willing to Take Insurance</p>
                            <span class="font-medium">
                                {{ $booking->playpal->willing_to_take_insurance ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Background Check Consent</p>
                            <span class="font-medium">
                                {{ $booking->playpal->background_check_consent ? 'Given' : 'Not Given' }}
                            </span>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-600 mb-1">Availability Slots</p>
                            @if ($booking->playpal->availability && is_array($booking->playpal->availability))
                                <ul class="list-disc list-inside text-sm text-gray-800">
                                    @foreach ($booking->playpal->availability as $slot)
                                        <li class="capitalize">{{ $slot }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-gray-500 italic">Not Provided</span>
                            @endif
                        </div>
                        @if($booking->playpal->profile_photo)
                            <div class="col-span-2">
                                <p class="text-gray-600 mb-1">Profile Photo</p>
                                <img src="{{ asset('storage/' . $booking->playpal->profile_photo) }}"
                                    alt="{{ $booking->playpal->user->name }}'s profile photo"
                                    class="w-48 h-48 rounded-lg object-cover">
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
                                    <p class="text-sm font-medium text-gray-900">Payment Made via PayPal</p>
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
                                    <p class="text-sm font-medium text-gray-900">Accepted by You</p>
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
                                    <p class="text-sm font-medium text-gray-900">Rejected by You</p>
                                    <p class="text-sm text-gray-500">{{ $booking->updated_at->format('F j, Y g:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-parent.layouts.parent-layout>