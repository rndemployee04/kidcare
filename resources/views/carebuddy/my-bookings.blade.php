<x-carebuddy.layouts.carebuddy>
    <div class="">
        <h2 class="text-2xl font-bold mb-6">Bookings Received</h2>
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow p-6">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="py-2">Parent</th>
                        <th class="py-2">Amount</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Platform Fee</th>
                        <th class="py-2">Your Earnings</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="border-t">
                            <td class="py-2">{{ $booking->parent->user->name ?? 'N/A' }}</td>
                            <td class="py-2">${{ $booking->amount }}</td>
                            <td class="py-2">
                                @if($booking->status === 'accepted')
                                    <span class="text-green-600 font-semibold">Accepted</span>
                                @elseif($booking->status === 'rejected')
                                    <span class="text-red-600 font-semibold">Rejected</span>
                                @elseif($booking->status === 'confirmed')
                                    <span class="text-blue-600 font-semibold">Confirmed</span>
                                @else
                                    <span class="text-yellow-500 font-semibold">Pending</span>
                                @endif
                            </td>
                            <td class="py-2">${{ $booking->platform_fee ?? '-' }}</td>
                            <td class="py-2">${{ $booking->carebuddy_earnings ?? '-' }}</td>
                            <td class="py-2">
                                @if($booking->status === 'confirmed')
                                    <form action="{{ route('carebuddy.bookings.accept', $booking->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-[#00bbae] hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Accept
                                        </button>
                                    </form>
                                    <form action="{{ route('carebuddy.bookings.reject', $booking->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md shadow-sm text-white bg-red-400 hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            Reject
                                        </button>
                                    </form>
                                @elseif($booking->status === 'accepted')
                                    <a href="{{ route('carebuddy.booking.show', $booking->id) }}"
                                        class="inline-flex items-center gap-1 text-[orange] no-underline hover:text-[#00bbae]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View
                                    </a>
                                @else
                                    <span class="text-red-600 font-semibold">Rejected</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-carebuddy.layouts.carebuddy>