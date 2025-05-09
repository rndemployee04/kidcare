<?php

namespace App\Livewire\Parent;

use Livewire\Component;

class Dashboard extends Component
{
    public function mount()
    {
        if (!auth()->user() || !auth()->user()->isParent()) {
            return redirect()->route('home');
        }
    }
    public function render()
    {
        return view('parent.dashboard');
    }
}
