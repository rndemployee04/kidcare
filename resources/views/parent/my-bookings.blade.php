<x-parent.layouts.parent-layout>
    <div class="git add .">
        <h2 class="text-2xl font-bold mb-6">My Bookings</h2>
        <div class="bg-white dark:bg-neutral-800 rounded-xl shadow p-6">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th class="py-2">Carebuddy</th>
                        <th class="py-2">Amount</th>
                        <th class="py-2">Status</th>
                        <th class="py-2">Paid At</th>
                        <th class="py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="border-t">
                            <td class="py-2">{{ $booking->carebuddy->user->name ?? 'N/A' }}</td>
                            <td class="py-2">${{ $booking->amount }}</td>
                            <td class="py-2">
                                @if ($booking->status === 'accepted')
                                    <span class="text-green-600 font-semibold">Accepted</span>
                                @elseif($booking->status === 'confirmed')
                                    <span class="text-blue-600 font-semibold">Confirmed</span>
                                @else
                                    <span class="text-yellow-500 font-semibold">Pending</span>
                                @endif
                            </td>
                            <td class="py-2">{{ $booking->paid_at ? $booking->paid_at->format('d M Y H:i') : '-' }}
                            </td>
                            <td class="py-2">
                                <a href="{{ route('parent.booking.show', $booking->id) }}" 
                                   class="inline-flex items-center gap-1 text-blue-600 no-underline hover:text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    View Details
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-parent.layouts.parent-layout>
