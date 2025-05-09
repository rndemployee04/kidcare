<x-layouts.onboarding
    class="max-w-4xl mx-auto px-6 py-10 text-slate-900 dark:text-slate-100 min-h-screen flex items-center justify-center">
    <div class="w-full">
        <x-auth-header :title="__('CareBuddy Profile Incomplete')" :description="__('You need to finish your registration before accessing your dashboard.')" />

        {{-- Info Board --}}
        <div class="mb-6">
            <div
                class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded shadow flex items-start gap-3">
                <svg class="w-6 h-6 mt-1 text-yellow-500" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M12 20.5a8.38 8.38 0 100-16.76 8.38 8.38 0 000 16.76z"></path>
                </svg>
                <div>
                    <strong>Registration Incomplete!</strong><br>
                    <span>Please complete your CareBuddy profile to access all features and your dashboard.</span>
                </div>
            </div>
        </div>

        <div class="flex justify-center mt-8">
            <a href="{{ route('carebuddy.register') }}"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold shadow transition text-lg">Continue
                Registration</a>
        </div>
    </div>
</x-layouts.onboarding>
