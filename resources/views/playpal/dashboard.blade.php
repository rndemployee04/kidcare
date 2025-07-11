<x-playpal.layouts.playpal>
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900">Welcome, {{ $user->name }}</h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">Here's an overview of your playpal activities.</p>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h4 class="text-xl font-semibold mb-6">Your Profile</h4>
            
            @if (session('booking'))
                @php
                    $alertType = session('alertType') ?? ($alertType ?? 'success');
                    $styles = [
                        'success' => [
                            'bg' => 'bg-green-50',
                            'border' => 'border-green-400',
                            'text' => 'text-green-700',
                            'icon' => 'text-green-400',
                        ],
                        'error' => [
                            'bg' => 'bg-red-50',
                            'border' => 'border-red-400',
                            'text' => 'text-red-700',
                            'icon' => 'text-red-400',
                        ],
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
                                    "
                            class="ml-auto text-xl leading-none text-gray-500 hover:text-black focus:outline-none">
                            &times;
                        </button>
                    </div>
                </div>
            @endif

            <div class="flex items-center justify-center">
                <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6 w-full">
                    <div class="flex items-center mb-6">
                        <div
                            class="flex-shrink-0 h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-500">
                            @if ($playpal && $playpal->profile_photo)
                                <img src="{{ asset('storage/' . $playpal->profile_photo) }}" alt="{{ $user->name }}"
                                    class="h-16 w-16 rounded-full object-cover">
                            @else
                                <span class="text-2xl font-medium">{{ substr($user->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                            <p class="text-sm text-gray-500">
                                {{ $playpal && $playpal->city ? $playpal->city : 'Location not set' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-2 space-y-3">
                        <div>
                            <span class="text-sm font-medium text-gray-500">Service Radius:</span>
                            <span
                                class="ml-2 text-sm text-gray-900">{{ $playpal && $playpal->service_radius ? $playpal->service_radius . ' km' : 'Not specified' }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Age Limit:</span>
                            <span
                                class="ml-2 text-sm text-gray-900">{{ $playpal && $playpal->child_age_limit ? $playpal->child_age_limit : 'Not specified' }}</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Availability:</span>
                            <span class="ml-2 text-sm text-gray-900">
                                @if ($playpal && $playpal->availability)
                                    {{ is_array($playpal->availability) ? implode(', ', $playpal->availability) : $playpal->availability }}
                                @else
                                    Not specified
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-500">Verification Status:</span>
                            <span
                                class="ml-2 text-sm px-2 py-1 rounded-full {{ $user->verification_status === 'approved' ? 'bg-green-100 text-green-800' : ($user->verification_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($user->verification_status) }}
                            </span>
                        </div>
                    </div>

                    @if ($playpal && $playpal->bio)
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-500 mb-1">About You:</h4>
                            <p class="text-sm text-gray-600">{{ $playpal->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-8">
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Recommended Parents</h3>
                {{-- @livewire('playpal.parent-recomendation') --}}
                <livewire:playpal.parent-recomendation>
            </div>
        </div>
</x-playpal.layouts.playpal>