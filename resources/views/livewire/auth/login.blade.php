<div class="flex flex-col gap-6">
  <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 bg-white shadow-xl rounded-lg overflow-hidden">

            <!-- Left Image -->
            <div class="flex flex-col justify-center text-center text-white bg-[#00bbae]">

                   <div class="mb-4 text-center">
                    <div class="w-[100px] h-[100px] bg-white text-green-600 rounded-full flex items-center justify-center mx-auto">
                        <h2 class="font-bold text-xl text-orange-400">KidCare</h2>
                    </div>
                </div>
                  <h3 class="text-2xl font-semibold mb-2">Welcome Back!</h3>
                <p class="text-sm mb-6">
                    To stay connected with us<br />
                    please login with your personal info
                </p>
                <flux:link :href="route('register')" wire:navigate class="inline-block text-white font-medium text-sm border border-white rounded-full px-5 py-1.5 mx-auto !no-underline ">
                            {{ __('Sign up') }}
                        </flux:link>
            </div>

            <!-- Right Form -->
            <div class="p-10 flex flex-col justify-center">

                <!-- Session Status -->
                <x-auth-session-status class="text-center mb-4 text-green-600" :status="session('status')" />

                <form wire:submit="login" class="flex flex-col gap-6">
                    <!-- Email Address -->
                    <flux:input wire:model="email" :label="__('Email address')" type="email" required autofocus autocomplete="email"
                        placeholder="email@example.com" />

                    <!-- Password -->
                    <div class="relative">
                        <flux:input wire:model="password" :label="__('Password')" type="password" required
                            autocomplete="current-password" :placeholder="__('Password')" viewable />

                        @if (Route::has('password.request'))
                            <flux:link class="relative float-right text-sm text-rose-500 hover:underline mt-2" :href="route('password.request')" wire:navigate>
                                {{ __('Forgot your password?') }}
                            </flux:link>
                        @endif
                    </div>

                    <!-- Remember Me -->
                    <flux:checkbox wire:model="remember" :label="__('Remember me')" />

                    <!-- Login Button -->
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full bg-orange-400 hover:bg-orange-500">{{ __('Log in') }}</flux:button>
                    </div>
                </form>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-grow h-px bg-gray-300"></div>
                    <span class="mx-4 text-sm text-gray-400">or login using below</span>
                    <div class="flex-grow h-px bg-gray-300"></div>
                </div>

                <!-- Social Login Buttons -->
                <div class="flex flex-row items-center justify-center gap-6">
                    <!-- Google -->
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                        class="h-8 w-8 cursor-pointer hover:scale-110 transition-transform" />

                    <!-- Facebook -->
                    <span class="h-9 w-9 flex items-center justify-center cursor-pointer hover:scale-110 transition-transform">
                        <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-9 w-9">
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
                        </svg>
                    </span>

                    <!-- LinkedIn -->
                    <img src="https://www.svgrepo.com/show/448234/linkedin.svg" alt="LinkedIn"
                        class="h-10 w-10 cursor-pointer hover:scale-110 transition-transform" />
                </div>

                <!-- Register Link -->
                @if (Route::has('register'))
                    <div class="mt-6 text-center text-sm text-zinc-600 dark:text-zinc-400">
                        {{ __('Don\'t have an account?') }}
                        <flux:link :href="route('register')" wire:navigate class="font-semibold text-[#00bbae] underline ml-1">
                            {{ __('Sign up') }}
                        </flux:link>
                    </div>
                @endif

            </div>
        </div>
    </div>

</div>
