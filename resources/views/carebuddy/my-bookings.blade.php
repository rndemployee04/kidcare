<x-carebuddy.layouts.carebuddy>
    <div class=" py-10">
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
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="border-t">
                            <td class="py-2">{{ $booking->parent->user->name ?? 'N/A' }}</td>
                            <td class="py-2">₹{{ $booking->amount }}</td>
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
                            <td class="py-2">₹{{ $booking->platform_fee ?? '-' }}</td>
                            <td class="py-2">₹{{ $booking->carebuddy_earnings ?? '-' }}</td>

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
