<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\CareBuddy;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Session;

class ParentBookingController extends Controller
{
    public function store(Request $request, $carebuddyId)
    {
        \Log::info('Booking POST hit!', ['user_id' => \Auth::id(), 'carebuddy_id' => $carebuddyId]);
        $user = Auth::user();
        // Role and relationship check
        if (!$user->isParent() || !$user->parentProfile) {
            return redirect()->back()->with('error', 'You must be logged in as a parent with a complete profile to book a carebuddy.');
        }
        $parent = $user->parentProfile;
        $carebuddy = CareBuddy::findOrFail($carebuddyId);
        $amount = $request->input('amount', 500); // default amount

        // Prevent double booking
        $existing = Booking::where('carebuddy_id', $carebuddy->id)
            ->where('parent_id', $parent->id)
            ->first();
        if ($existing) {
            return redirect()->back()->with('error', 'You have already booked this carebuddy.');
        }

        $duration = $request->input('duration');

        $booking = Booking::create([
            'carebuddy_id' => $carebuddy->id,
            'parent_id' => $parent->id,
            'status' => 'confirmed',
            'amount' => $amount,
            'paid_at' => Carbon::now(),
            'duration' => $duration,
        ]);
        return redirect()->route('parent.payment.success');
    }
    public function myBookings()
    {
        $parent = Auth::user()->parentProfile;
        if (!$parent) {
            return redirect()->route('parent.dashboard')->with('error', 'No parent profile found.');
        }
        $bookings = Booking::with('carebuddy.user')->where('parent_id', $parent->id)->latest()->get();
        return view('parent.my-bookings', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with(['carebuddy.user', 'parent.user', 'playPal.user'])->findOrFail($id);

        // Ensure the booking belongs to the current user
        if ($booking->parent_id !== Auth::user()->parentProfile->id) {
            abort(403, 'Unauthorized');
        }

        if ($booking->status !== 'accepted' && $booking->status !== 'completed') {
            abort(403, 'You cannot access this booking until it is accepted.');
        }

        return view('parent.booking-details', compact('booking'));
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

        return redirect()->route('parent.bookings');
    }

    public function reject($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        // Instead of deleting, update the status to cancelled
        $booking->update([
            'status' => 'rejected',
        ]);

        // Store a message in the session for the parent to see
        // This will be stored in the database and retrieved when the parent views their dashboard
        Session::put('parent_' . $booking->parent_id . '_booking_cancelled', [
            'message' => 'Your booking with ' . $booking->playPal->user->name . ' was cancelled. Your payment will be refunded.',
            'booking_id' => $booking->id
        ]);

        return redirect()->route('parent.bookings');
    }

    public function destroy($id)
    {

        $booking = Booking::find($id);

        if ($booking) {
            $booking->delete();
            return redirect()->route('parent.dashboard')->with('Booking deleted successfully !');
        }

        return redirect()->route('parent.dashboard')->with('Something went wrong !');
    }
}
