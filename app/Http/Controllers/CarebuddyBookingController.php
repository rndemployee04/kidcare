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



    public function reject($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->delete();
        return redirect()->route('carebuddy.bookings');
    }
    public function myBookings()
    {
        $carebuddy = Auth::user()->careBuddy;
        $bookings = Booking::with('parent.user')->where('carebuddy_id', $carebuddy->id)->latest()->get();
        // Ensure platform_fee and carebuddy_earnings are set for display
        foreach ($bookings as $booking) {
            if (is_null($booking->platform_fee)) {
                $booking->platform_fee = 0;
            }
            if (is_null($booking->carebuddy_earnings)) {
                $booking->carebuddy_earnings = 0;
            }
        }
        return view('carebuddy.my-bookings', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['parent.user', 'carebuddy.user'])->findOrFail($id);
        
        // Ensure the booking belongs to the current carebuddy
        if ($booking->carebuddy_id !== Auth::user()->careBuddy->id) {
            abort(403, 'Unauthorized');
        }

        return view('carebuddy.booking-details', compact('booking'));
    }
}
