<x-layouts.app>
    <div class="max-w-4xl mx-auto py-10">
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
                            <td class="py-2">₹{{ $booking->amount }}</td>
                            <td class="py-2">
                                @if($booking->carebuddy_accepted)
                                    <span class="text-green-600 font-semibold">Accepted</span>
                                @else
                                    <span class="text-yellow-500 font-semibold">Pending</span>
                                @endif
                            </td>
                            <td class="py-2">₹{{ $booking->platform_fee ?? '-' }}</td>
                            <td class="py-2">₹{{ $booking->carebuddy_earnings ?? '-' }}</td>
                            <td class="py-2">
                                @if(!$booking->carebuddy_accepted)
                                    <form action="/carebuddy/bookings/accept/{{ $booking->id }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded">Accept</button>
                                    </form>
                                    <form action="/carebuddy/bookings/reject/{{ $booking->id }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">Reject</button>
                                    </form>
                                @else
                                    <span class="text-gray-400">--</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-6 text-gray-500">No bookings found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
