<?php
namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegisterMail;
#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'parent';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{};:\",.\/?]).+$/',
                'max:255',
            ],
            'role' => ['required', 'in:parent,carebuddy,playpal'],
        ], [
            'password.min' => 'Password too short',
            'password.regex' => 'Password must include one uppercase, number, and special character',
            'password.confirmed' => 'Passwords don\'t match',
        ]);
        $unhashedPass = $validated['password'];
        $validated['password'] = Hash::make($validated['password']);
        $validated['verification_status'] = 'pending';

        $user = User::create($validated);

        event(new Registered($user));
        Auth::login($user);

        // After registration, mark registration as incomplete
        $user->registration_complete = false;
        $user->save();

        try {
            Mail::to($user->email)->send(new UserRegisterMail($user, $unhashedPass));
        } catch (\Throwable $th) {
            \Log::error('Failed to send registration email', ['user' => $user, 'error' => $th]);
        }
        // Redirect to the appropriate registration form
        match ($user->role) {
             'parent' => $this->redirect(route('parent.register'), navigate: true),
             'carebuddy' => $this->redirect(route('carebuddy.register'), navigate: true),
             'playpal' => $this->redirect(route('playpal.register'), navigate: true),
        };
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
