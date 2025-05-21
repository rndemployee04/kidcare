<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CarebuddyBookingController extends Controller
{
    public function dashboard()
    {
        $carebuddy = Auth::user()->careBuddy;
        $bookings = Booking::with('parent.user')->where('carebuddy_id', $carebuddy->id)->latest()->get();
        return view('carebuddy.dashboard', compact('bookings'));
    }
    public function accept($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $platformFee = round($booking->amount * 0.2, 2);
        $earnings = $booking->amount - $platformFee;
        $booking->update([
            'carebuddy_accepted' => true,
            'accepted_at' => Carbon::now(),
            'platform_fee' => $platformFee,
            'carebuddy_earnings' => $earnings,
            'status' => 'accepted',
        ]);
        return redirect()->route('carebuddy.bookings');
    }
    public function myBookings()
    {
        $carebuddy = Auth::user()->careBuddy;
        $bookings = Booking::with('parent.user')->where('carebuddy_id', $carebuddy->id)->latest()->get();
        return view('carebuddy.my-bookings', compact('bookings'));
    }
}
