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
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()_+\-=\[\]{};:\",.\/?]).+$/',
                'max:255',
            ],
            'role' => ['required', 'in:parent,carebuddy'],
        ], [
            'password.min' => 'Password too short',
            'password.regex' => 'Password must include one uppercase, number, and special character',
            'password.confirmed' => 'Passwords don\'t match',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['verification_status'] = 'pending';

        $user = User::create($validated);

        event(new Registered($user));
        Auth::login($user);

        // After registration, mark registration as incomplete
        $user->registration_complete = false;
        $user->save();
        
        // Redirect to the appropriate registration form
        $route = $user->role === 'carebuddy' ? 'carebuddy.register' : 'parent.register';
        $this->redirect(route($route), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
