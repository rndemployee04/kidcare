<?php
namespace App\Livewire\PlayPal;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\PlayPal;
use App\Models\Booking;
use App\Models\Child;

class BookingForm extends Component
{
    public $parent_id;
    public $child_id;
    public $date;
    public $time;
    public $duration_days;
    public $amount;

    protected $rules = [
        'parent_id' => 'required|exists:users,id',
        'child_id' => 'required|exists:children,id',
        'date' => 'required|date',
        'time' => 'required',
        'duration_days' => 'required|integer|min:1',
        'amount' => 'required|numeric|min:0',
    ];

    public function submit()
    {
        $this->validate();
        $user = Auth::user();
        $playpal = PlayPal::where('user_id', $user->id)->first();
        Booking::create([
            'playpal_id' => $playpal->id,
            'parent_id' => $this->parent_id,
            'child_id' => $this->child_id,
            'date' => $this->date,
            'time' => $this->time,
            'duration_days' => $this->duration_days,
            'amount' => $this->amount,
            'status' => 'pending',
        ]);
        session()->flash('success', 'Booking request sent to parent!');
        return redirect()->route('playpal.dashboard');
    }

    public function render()
    {
        $children = Child::where('parent_id', $this->parent_id)->get();
        return view('playpal.booking-form', [
            'children' => $children,
        ]);
    }
}
