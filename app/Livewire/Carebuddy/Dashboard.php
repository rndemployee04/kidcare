<?php

namespace App\Livewire\Carebuddy;

use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();
        $carebuddy = $user->careBuddy;
        
        $bookings = [];
        if ($carebuddy) {
            $bookings = \App\Models\Booking::with(['parent.user'])
                ->where('carebuddy_id', $carebuddy->id)
                ->latest()
                ->get();
        }
        return view('livewire.carebuddy.dashboard', [
            'user' => $user,
            'carebuddy' => $carebuddy,
            'bookings' => $bookings
        ]);
    }
}
