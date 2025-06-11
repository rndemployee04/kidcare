<x-carebuddy.layouts.carebuddy>
<div class="container mx-auto py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6">My Bookings</h2>
        
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid At</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Earnings</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $booking->parent->user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $booking->parent->user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">${{ $booking->amount }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($booking->status === 'confirmed')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Confirmed
                                    </span>
                                @elseif($booking->status === 'accepted')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Accepted
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">
                                    {{ $booking->paid_at ? $booking->paid_at->format('d M Y H:i') : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">${{ $booking->carebuddy_earnings ?? 0 }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($booking->status === 'confirmed' && !$booking->carebuddy_accepted)
                                    <div class="flex space-x-2">
                                        <form action="{{ route('carebuddy.accept', $booking->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Accept
                                            </button>
                                        </form>
                                        <form action="{{ route('carebuddy.reject', $booking->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <a href="{{ route('carebuddy.booking.show', $booking->id) }}" 
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
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center">
                                <p class="text-sm text-gray-500">No bookings found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-carebuddy.layouts.carebuddy>
