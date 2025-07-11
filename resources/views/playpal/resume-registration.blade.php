<x-layouts.onboarding class="max-w-4xl mx-auto px-6 py-12 text-slate-900 dark:text-slate-100 min-h-screen flex items-center justify-center">
    <div class="w-full">
        <x-auth-header :title="__('Resume PlayPal Registration')" :description="__('You need to finish your registration before accessing your dashboard.')" />
        <div class="mb-8">
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 p-5 rounded-lg shadow flex items-start gap-4">
                <i class="fas fa-exclamation-circle text-yellow-500 text-2xl mt-1"></i>
                <div>
                    <p class="font-bold text-lg">Resume Registration</p>
                    <p class="text-sm">Please complete your PlayPal profile to access all features and your dashboard.</p>
                </div>
            </div>
        </div>
        <div class="flex justify-center mt-10">
            <a href="{{ route('playpal.register') }}"
                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold shadow-lg transition-all duration-200 text-lg">
                Continue Registration
            </a>
        </div>
    </div>
</x-layouts.onboarding>
