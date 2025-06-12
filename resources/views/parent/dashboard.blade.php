<x-parent.layouts.parent-layout>
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Welcome to your Dashboard</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Find carebuddies to help with your childcare needs.</p>
        </div>
        @if(session('booking'))
            @php
                $alertType = session('alertType') ?? $alertType ?? 'success';
                $styles = [
                    'success' => ['bg' => 'bg-green-50', 'border' => 'border-green-400', 'text' => 'text-green-700', 'icon' => 'text-green-400'],
                    'error' => ['bg' => 'bg-red-50', 'border' => 'border-red-400', 'text' => 'text-red-700', 'icon' => 'text-red-400'],
                ];
                $style = $styles[$alertType] ?? $styles['success'];
            @endphp

            <div x-data="{ show: true }" x-show="show" x-transition
                class="{{ $style['bg'] }} border-l-4 {{ $style['border'] }} p-4 mb-6 rounded-r-lg relative">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 {{ $style['icon'] }}" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium {{ $style['text'] }}">{{ session('booking') }}</p>
                    </div>
                    <button @click="
                        fetch('{{ route('dismiss.alert') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ key: '{{ $dismissedKey }}' })
                        }).then(() => show = false)
                    " class="ml-auto text-xl leading-none text-gray-500 hover:text-black focus:outline-none">
                        &times;
                    </button>
                </div>
            </div>
        @endif


        <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
            <h4 class="text-lg font-medium text-gray-900 mb-4">Recommended Carebuddies</h4>

            @livewire('parent.carebuddy-recommendations')
        </div>
    </div>

    <div class="container mx-auto py-8">
        <!-- Flash Messages -->

        @if(session('success'))
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
        </div>
    </div>
</x-parent.layouts.parent-layout>