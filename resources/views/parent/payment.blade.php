<x-parent.layouts.parent-layout>
    <div class="max-w-lg mx-auto px-4 py-12">
        <a href="{{ route('parent.dashboard') }}" class="inline-flex items-center text-sm text-blue-600 hover:underline mb-6">
            <i class="fa fa-arrow-left mr-2"></i> Back to Recommendations
        </a>
        <div class="bg-white shadow rounded-2xl p-8 flex flex-col items-center">
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded w-full text-center">
                    {{ session('error') }}
                </div>
            @endif
            <div class="mb-4 flex flex-col items-center">
                <i class="fa-solid fa-credit-card text-4xl text-blue-500 mb-2"></i>
                <h2 class="text-2xl font-bold mb-1">Payment</h2>
                <div class="text-gray-500 text-center text-base">Booking for <span class="font-semibold">{{ $carebuddy_name ?? 'N/A' }}</span></div>
            </div>
            <div class="w-full mb-6 divide-y divide-gray-200">
                <div class="flex items-center justify-between py-2">
                    <span class="text-gray-600 font-medium">Carebuddy</span>
                    <span class="font-bold text-gray-900">{{ $carebuddy_name ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-gray-600 font-medium">Service Radius</span>
                    <span class="font-bold text-gray-900">{{ $service_radius ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-gray-600 font-medium">Total Amount</span>
                    <span class="font-bold text-green-600 text-lg">₹{{ $amount ?? '500' }}</span>
                </div>
            </div>
            <form action="{{ route('parent.book.store', $carebuddy_id) }}" method="POST" class="w-full">
                @csrf
                <input type="hidden" name="amount" value="{{ $amount ?? '500' }}">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2 text-lg mt-2">
                    <i class="fa-solid fa-lock"></i> Complete Payment
                </button>
            </form>
        </div>
    </div>
</x-parent.layouts.parent-layout>
