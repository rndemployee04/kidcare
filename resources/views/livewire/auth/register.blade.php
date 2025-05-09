<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name"
            :placeholder="__('Full name')" />

        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email address')" type="email" required autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <flux:input wire:model="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" viewable />

        <!-- Confirm Password -->
        <flux:input wire:model="password_confirmation" :label="__('Confirm password')" type="password" required
            autocomplete="new-password" :placeholder="__('Confirm password')" viewable />

        <div class="flex flex-col gap-1">
            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">
                {{ __('I am registering as') }}
            </label>

            <div class="flex border border-zinc-300 dark:border-zinc-700 rounded-lg overflow-hidden w-full max-w-md">
                <button type="button" wire:click="$set('role', 'parent')"
                    class="w-1/2 px-4 py-3 text-sm font-semibold transition-all duration-150 focus:outline-none
                            {{ $role === 'parent'
                                ? 'bg-primary text-white shadow-inner'
                                : 'bg-white text-zinc-700 hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700' }}">
                    👨‍👧 {{ __('Parent') }}
                </button>

                <button type="button" wire:click="$set('role', 'carebuddy')"
                    class="w-1/2 px-4 py-3 text-sm font-semibold transition-all duration-150 focus:outline-none border-l border-zinc-300 dark:border-zinc-700
                            {{ $role === 'carebuddy'
                                ? 'bg-primary text-white shadow-inner'
                                : 'bg-white text-zinc-700 hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700' }}">
                    🧑‍⚕️ {{ __('CareBuddy') }}
                </button>
            </div>
        </div>



        <!-- Submit -->
        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Create account') }}
            </flux:button>
        </div>
    </form>

    <!-- Login Link -->
    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Already have an account?') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
    </div>
</div>
