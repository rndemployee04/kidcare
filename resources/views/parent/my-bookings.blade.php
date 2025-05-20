<x-layouts.app>
    <div class="max-w-4xl mx-auto py-10">
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
                            <td class="py-2">₹{{ $booking->amount }}</td>
                            <td class="py-2">
                                @if($booking->carebuddy_accepted)
                                    <span class="text-green-600 font-semibold">Accepted</span>
                                @else
                                    <span class="text-yellow-500 font-semibold">Pending</span>
                                @endif
                            </td>
                            <td class="py-2">{{ $booking->paid_at ? $booking->paid_at->format('d M Y H:i') : '-' }}</td>
                            <td class="py-2">
                                <a href="/parent/carebuddy/{{ $booking->carebuddy_id }}" class="text-blue-600 underline">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center py-6 text-gray-500">No bookings found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
