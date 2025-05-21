<x-layouts.app>
    <div class="flex justify-center items-center min-h-[80vh] bg-gray-100 dark:bg-neutral-900">
        <div class="bg-white dark:bg-neutral-800 rounded-3xl shadow-lg max-w-md w-full p-10 flex flex-col items-center">
            <div class="mb-6 flex flex-col items-center">
                <i class="fa-solid fa-credit-card text-5xl text-blue-500 mb-2"></i>
                <h2 class="text-2xl font-bold mb-1">Payment</h2>
                <div class="text-gray-600 dark:text-gray-300 text-center">Booking for <span class="font-semibold">{{ $carebuddy->user->name ?? 'N/A' }}</span></div>
            </div>
            <div class="w-full mb-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-700 dark:text-gray-200">Carebuddy</span>
                    <span class="font-semibold">{{ $carebuddy->user->name ?? 'N/A' }}</span>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-700 dark:text-gray-200">Service Radius</span>
                    <span>{{ $carebuddy->service_radius ?? 'N/A' }} km</span>
                </div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-gray-700 dark:text-gray-200">Total Amount</span>
                    <span class="font-bold text-green-600 dark:text-green-400">₹{{ $amount ?? '500' }}</span>
                </div>
            </div>
            <form action="/parent/payment/success" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-lock"></i> Complete Payment
                </button>
            </form>
        </div>
    </div>
</x-layouts.app>
