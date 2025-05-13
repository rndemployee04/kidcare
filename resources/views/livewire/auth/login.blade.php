<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email address')" type="email" required autofocus autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <div class="relative">
            <flux:input wire:model="password" :label="__('Password')" type="password" required
                autocomplete="current-password" :placeholder="__('Password')" viewable />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <flux:checkbox wire:model="remember" :label="__('Remember me')" />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
        </div>
    </form>

    <!-- Social Login Text and Logos -->
    <div class="flex flex-col items-center mt-4 gap-2">
        <span class="text-sm text-zinc-500 dark:text-zinc-400">or login using below</span>
        <div class="flex flex-row items-center justify-center gap-6">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                class="h-8 w-8 cursor-pointer hover:scale-110 transition-transform" />
            <span class="h-9 w-9 flex items-center justify-center cursor-pointer hover:scale-110 transition-transform">
                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-9 w-9">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <circle cx="16" cy="16" r="14" fill="url(#paint0_linear_87_7208)"></circle>
                        <path
                            d="M21.2137 20.2816L21.8356 16.3301H17.9452V13.767C17.9452 12.6857 18.4877 11.6311 20.2302 11.6311H22V8.26699C22 8.26699 20.3945 8 18.8603 8C15.6548 8 13.5617 9.89294 13.5617 13.3184V16.3301H10V20.2816H13.5617V29.8345C14.2767 29.944 15.0082 30 15.7534 30C16.4986 30 17.2302 29.944 17.9452 29.8345V20.2816H21.2137Z"
                            fill="white"></path>
                        <defs>
                            <linearGradient id="paint0_linear_87_7208" x1="16" y1="2" x2="16" y2="29.917"
                                gradientUnits="userSpaceOnUse">
                                <stop stop-color="#18ACFE"></stop>
                                <stop offset="1" stop-color="#0163E0"></stop>
                            </linearGradient>
                        </defs>
                    </g>
                </svg>
            </span>
            <img src="https://www.svgrepo.com/show/448234/linkedin.svg" alt="LinkedIn"
                class="h-8 w-8 cursor-pointer hover:scale-110 transition-transform" />
        </div>
    </div>

    @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>