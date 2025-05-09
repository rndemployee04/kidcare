<?php

namespace App\Livewire\Carebuddy;

use Livewire\Component;

class Dashboard extends Component
{
    public function mount()
    {
        if (!auth()->user() || !auth()->user()->isCareBuddy()) {
            return redirect()->route('home');
        }
    }
    public function render()
    {
        return view('carebuddy.dashboard');
    }
}
