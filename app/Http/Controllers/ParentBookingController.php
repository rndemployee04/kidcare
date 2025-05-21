<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\CareBuddy;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ParentBookingController extends Controller
{
    public function store(Request $request, $carebuddyId)
    {
        $parent = Auth::user()->parent;
        $carebuddy = CareBuddy::findOrFail($carebuddyId);
        $amount = $request->input('amount', 500); // default amount
        $booking = Booking::create([
            'carebuddy_id' => $carebuddy->id,
            'parent_id' => $parent->id,
            'status' => 'confirmed',
            'amount' => $amount,
            'paid_at' => Carbon::now(),
        ]);
        return redirect()->route('parent.payment.success');
    }
    public function myBookings()
    {
        $parent = Auth::user()->parent;
        $bookings = Booking::with('carebuddy.user')->where('parent_id', $parent->id)->latest()->get();
        return view('parent.my-bookings', compact('bookings'));
    }
}
