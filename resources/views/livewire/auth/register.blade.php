<div
    class="w-full px-6 py-1 text-slate-900 dark:text-slate-100 bg-white shadow-xl rounded overflow-hidden register-fom">
    <div class="flex flex-col gap-0 md:p-12 ">

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <!-- Registration Form -->
        <form wire:submit="register" class="flex flex-col gap-6 ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline">
                <!-- Name -->
                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
                    :placeholder="__('Full name')" />

                <!-- Email -->
                <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
                    placeholder="email@example.com" />
            </div>
            <!-- Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-baseline">
                <flux:input wire:model="password" :label="__('Password')" type="password" required
                    autocomplete="new-password" :placeholder="__('Password')" viewable hide-errors />

                <!-- Confirm Password -->
                <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required
                    autocomplete="new-password" :placeholder="__('Confirm password')" viewable />
            </div>
            <!-- Role Selection -->
            <div class="flex flex-col md:gap-2">
                <label for="role" class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                    {{ __('I am registering as') }}
                </label>
                <div class="flex justify-between gap-4">
                    <!-- Parent Button -->
                    <button type="button" wire:click="$set('role', 'parent')"
                        class="flex-1 flex flex-col items-center py-3 rounded-lg border-2 transition-all text-sm font-semibold gap-1
                        {{ $role === 'parent' ? 'bg-primary text-white border-primary ring-2 ring-primary' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 border-zinc-300 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700' }}">
                        <span class="text-2xl">👨‍👧</span>
                        <span>{{ __('Parent') }}</span>
                    </button>

                    <!-- CareBuddy Button -->
                    {{-- <button type="button" wire:click="$set('role', 'carebuddy')"
                        class="flex-1 flex flex-col items-center py-3 rounded-lg border-2 transition-all text-sm font-semibold gap-1
                        {{ $role === 'carebuddy' ? 'bg-primary text-white border-primary ring-2 ring-primary' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 border-zinc-300 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700' }}">
                        <span class="text-2xl">🧑‍⚕️</span>
                        <span>{{ __('CareBuddy') }}</span>
                    </button> --}}

                    <!-- PlayPal Button -->
                    <button type="button" wire:click="$set('role', 'playpal')"
                        class="flex-1 flex flex-col items-center py-3 rounded-lg border-2 transition-all text-sm font-semibold gap-1
                        {{ $role === 'playpal' ? 'bg-primary text-white border-primary ring-2 ring-primary' : 'bg-white dark:bg-zinc-800 text-zinc-700 dark:text-zinc-200 border-zinc-300 dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-700' }}">
                        <span class="text-2xl">🤸‍♂️</span>
                        <span>{{ __('PlayPal') }}</span>
                    </button>
                </div>
            </div>

            <!-- Submit -->
            <div>
                <flux:button type="submit" variant="primary" class="w-full  bg-orange-400 hover:bg-orange-500">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <!-- Social Signup Divider -->
        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-zinc-700"></div>
            <span class="mx-4 text-xs text-zinc-500 dark:text-zinc-400">or signup using below</span>
            <div class="flex-grow border-t border-zinc-700"></div>
        </div>

        <!-- Social Buttons -->
        <div class="flex justify-center gap-6 bg-white dark:bg-zinc-800 rounded-xl py-3 px-6 shadow">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                class="h-8 w-8 cursor-pointer hover:scale-110 transition-transform" />
            <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="h-9 w-9 cursor-pointer hover:scale-110 transition-transform">
                <circle cx="16" cy="16" r="14" fill="url(#paint0_linear_87_7208)" />
                <path
                    d="M21.2137 20.2816L21.8356 16.3301H17.9452V13.767C17.9452 12.6857 18.4877 11.6311 20.2302 11.6311H22V8.26699C22 8.26699 20.3945 8 18.8603 8C15.6548 8 13.5617 9.89294 13.5617 13.3184V16.3301H10V20.2816H13.5617V29.8345C14.2767 29.944 15.0082 30 15.7534 30C16.4986 30 17.2302 29.944 17.9452 29.8345V20.2816H21.2137Z"
                    fill="white" />
                <defs>
                    <linearGradient id="paint0_linear_87_7208" x1="16" y1="2" x2="16" y2="29.917"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#18ACFE" />
                        <stop offset="1" stop-color="#0163E0" />
                    </linearGradient>
                </defs>
            </svg>
            <img src="https://www.svgrepo.com/show/448234/linkedin.svg" alt="LinkedIn"
                class="h-8 w-8 cursor-pointer hover:scale-110 transition-transform" />
        </div>

        <!-- Login Link -->
        <div class="text-center text-sm text-zinc-600 dark:text-zinc-400 mt-6">
            {{ __('Already have an account?') }}
            <flux:link :href="route('login')" wire:navigate class="underline">{{ __('Log in') }}</flux:link>
        </div>
    </div>
</div>