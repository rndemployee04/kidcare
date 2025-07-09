<?php

namespace App\Livewire\Auth;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // $this->checkAndCompleteBookings(Auth::user());
        // Let the role.redirect middleware handle the redirection
        $this->redirectIntended(default: route('login.redirect', absolute: false), navigate: true);
    }



    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }

    private function checkAndCompleteBookings($user): void
    {
        $now = Carbon::now();
        // $now = Carbon::now()->addHours(10);
        $query = Booking::query()
            ->where('status', 'accepted');

        // Filter based on user type
        if ($user->isPlayPal() && $user->playPal) {
            $query->where('playpal_id', $user->playPal->id);
        } elseif ($user->isParent() && $user->parent) {
            $query->where('parent_id', $user->parent->id);
        } else {
            return;
        }

        $bookings = $query->get();

        foreach ($bookings as $booking) {
            $duration = json_decode($booking->duration, true);
            if (!$duration || !isset($duration['type']))
                continue;

            $end = null;

            switch ($duration['type']) {
                case 'time':
                    if (isset($duration['start'], $duration['hours'])) {
                        // Parse time today
                        $start = Carbon::parse(today()->format('Y-m-d') . ' ' . $duration['start']);
                        $end = $start->copy()->addHours((int) $duration['hours']);
                    }
                    break;

                case 'date':
                    if (isset($duration['end'])) {
                        $end = Carbon::parse($duration['end'])->endOfDay();
                    }
                    break;

                case 'week':
                    if (isset($duration['week'])) {
                        $start = Carbon::createFromFormat('o-\WW', $duration['week']);
                        $end = $start->copy()->addDays(6)->endOfDay();
                    }
                    break;
            }

            // dd([
//     'start' => $start?->toDateTimeString(),
//     'end' => $end?->toDateTimeString(),
//     'now' => $now->toDateTimeString(),
//     'is_now_greater' => $now->greaterThan($end),
// ]);

            if ($end && $now->greaterThan($end)) {
                $booking->update(['status' => 'completed']);
            }
        }
    }

}
