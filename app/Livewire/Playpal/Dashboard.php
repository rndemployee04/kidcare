<?php
namespace App\Livewire\Playpal;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\PlayPal;
use App\Models\Booking;

class Dashboard extends Component
{
    public $bookings;

    public function mount()
    {
        $user = Auth::user();
        $playpal = PlayPal::where('user_id', $user->id)->first();
        $this->bookings = Booking::with(['parent', 'child'])
            ->where('playpal_id', $playpal->id)
            ->latest()->get();
    }

    public function render()
    {
        return view('playpal.dashboard', [
            'bookings' => $this->bookings,
        ]);
    }
}
