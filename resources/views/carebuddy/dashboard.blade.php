<x-carebuddy.layouts.carebuddy>
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Welcome, {{ $user->name }}</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">Here's an overview of your carebuddy activities.</p>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h4 class="text-xl font-semibold mb-6">Your Profile</h4>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center mb-6">
                        <div
                            class="flex-shrink-0 h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500">
                            @if ($carebuddy && $carebuddy->profile_photo)
                                <img src="{{ asset('storage/' . $carebuddy->profile_photo) }}" alt="{{ $user->name }}"
                                    class="h-16 w-16 rounded-full object-cover">
                            @else
                                <span class="text-2xl font-medium">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">
                                {{ $carebuddy && $carebuddy->city ? $carebuddy->city : 'Location not set' }}</p>
                        </div>
                    </div>

                    <div class="mt-2 space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Service Radius:</span>
                            <span
                                class="ml-2 text-sm text-gray-900">{{ $carebuddy && $carebuddy->service_radius ? $carebuddy->service_radius . ' km' : 'Not specified' }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Age Limit:</span>
                            <span
                                class="ml-2 text-sm text-gray-900">{{ $carebuddy && $carebuddy->child_age_limit ? $carebuddy->child_age_limit : 'Not specified' }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Availability:</span>
                            <span class="ml-2 text-sm text-gray-900">
                                @if ($carebuddy && $carebuddy->availability)
                                    {{ is_array($carebuddy->availability) ? implode(', ', $carebuddy->availability) : $carebuddy->availability }}
                                @else
                                    Not specified
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Verification Status:</span>
                            <span
                                class="ml-2 text-sm px-2 py-1 rounded-full {{ $user->verification_status === 'approved' ? 'bg-green-100 text-green-800' : ($user->verification_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($user->verification_status) }}
                            </span>
                        </div>
                    </div>

                    @if ($carebuddy && $carebuddy->bio)
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-500 mb-1">About You:</h4>
                            <p class="text-sm text-gray-600">{{ $carebuddy->bio }}</p>
                        </div>
                    @endif
                </div>

                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Upcoming Schedule</h3>

                    @if ($bookings->count())
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Parent
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="px-4 py-2">
                                            {{ $booking->parent && $booking->parent->user ? $booking->parent->user->name : 'Unknown' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            @if ($booking->status === 'accepted')
                                                <span class="text-green-600 font-semibold">Accepted</span>
                                            @else
                                                <form action="{{ route('carebuddy.bookings.accept', $booking->id) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-[#00bbae] hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        Accept
                                                    </button>
                                                </form>
                                                @if ($booking->status === 'confirmed')
                                                    <span class="text-blue-600 font-semibold ml-2">Confirmed</span>
                                                @else
                                                    <span class="text-yellow-500 font-semibold ml-2">Pending</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-4 py-2">
                                            {{ $booking->paid_at ? $booking->paid_at->format('d M Y H:i') : '-' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            ${{ $booking->amount }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="border border-gray-200 rounded-md p-4 text-center">
                            <p class="text-gray-500">No upcoming bookings at the moment.</p>
                            <p class="text-sm text-gray-400 mt-1">When parents book your services, they'll appear here.
                            </p>
                        </div>
                    @endif

                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Notifications</h3>
                        <div class="border border-gray-200 rounded-md p-4 text-center">
                            <p class="text-gray-500">No new notifications.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-carebuddy.layouts.carebuddy>
