<x-parent.layouts.parent-layout>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Welcome to your Dashboard</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                You can manage your bookings below and collect payment for completed services.
            </p>
        </div>
       

    </div>

    <div class="container mx-auto py-8">
        <!-- Flash Messages -->

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-6">Dashboard</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-blue-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Active Bookings</h3>
                    <p class="text-3xl font-bold">{{ $activeBookings }}</p>
                </div>
                <div class="bg-green-50 p-6 rounded-lg">
                    <h3 class="text-lg font-semibold mb-2">Completed Bookings</h3>
                    <p class="text-3xl font-bold">{{ $completedBookings }}</p>
                </div>
            </div>

            <div class="mt-5">
                @if ($bookings && count($bookings))
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">PlayPal
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="px-4 py-2 font-semibold text-gray-900">
                                            {{ $booking->playPal->user->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2">
                                            @if ($booking->status === 'accepted')
                                                <span
                                                    class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Accepted</span>
                                            @elseif($booking->status === 'rejected')
                                                <span
                                                    class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">Rejected</span>
                                            @elseif($booking->status === 'confirmed')
                                                <span
                                                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">Confirmed</span>
                                            @else
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Pending</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 text-gray-700">
                                            {{ $booking->created_at ? $booking->created_at->format('d M Y H:i') : 'N/A' }}
                                        </td>
                                        <td class="px-4 py-2 text-green-700 font-bold">${{ $booking->amount }}</td>
                                        <td class="px-4 py-2">
                                    
                                            @if ($booking->status === 'confirmed' && !$booking->carebuddy_accepted)
                                                <div class="flex space-x-2">
                                                    <form action="{{ route('parent.bookings.accept', $booking->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-[#00bbae] hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                            Accept
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('parent.bookings.reject', $booking->id) }}" method="POST"
                                                        class="inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-orange-400 hover:bg-[#00bbae] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                            Reject
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <a href="{{ route('parent.booking.show', $booking->id) }}"
                                                    class="inline-flex items-center gap-1 text-blue-600 no-underline hover:text-blue-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    View Details
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="border border-gray-200 rounded-md p-4 text-center">
                        <p class="text-gray-500">No upcoming bookings at the moment.</p>
                        <p class="text-sm text-gray-400 mt-1">When Playpals book your services, they'll appear here.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-parent.layouts.parent-layout>