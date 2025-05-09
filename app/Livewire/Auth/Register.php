<?php
namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

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
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:parent,carebuddy'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['verification_status'] = 'pending';

        $user = User::create($validated);

        event(new Registered($user));
        Auth::login($user);

        // After registration, go to the individual registration form, not dashboard
        $route = $user->role === 'carebuddy' ? 'carebuddy.register' : 'parent.register';
        $this->redirect(route($route), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
