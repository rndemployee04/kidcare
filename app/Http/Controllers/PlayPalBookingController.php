<?php

namespace App\Http\Controllers;

use App\Models\Parents;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Booking;
use Auth;
use Log;
class PlayPalBookingController extends Controller
{
    public function store(Request $request, $id)
    {

        $request->validate([
            'amount' => 'required',
            'preferred_slot' => 'required',
        ]);

        Log::info('Booking POST hit!', ['user_id' => Auth::id(), 'parent_id' => $id]);
        $user = Auth::user();
        // Role and relationship check
        if (!$user->isPlayPal() || !$user->playPal) {
            return redirect()->back()->with('error', 'You must be logged in as a playpal with a complete profile to book a parent.');
        }

        $playpal = $user->playPal;
        $parent = Parents::findOrFail($id);
        $amount = $request->input('amount', 500); // default amount

        // Prevent double booking
        $existing = Booking::where('playpal_id', $playpal->id)
            ->where('parent_id', $parent->id)
            ->where('status', '!=', 'rejected')
            ->where('status', '!=', 'accepted')
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You have already booked this parent.');
        }

        $preferredSlot = $request->input('preferred_slot'); // e.g. 'morning'
        $playpalAvailability = $playpal->availability ?? [];
        
        if (!in_array($preferredSlot, $playpalAvailability)) {
            return redirect()->back()->with('error', 'You are not available at the parent\'s preferred drop-off time.');
        }

        $duration = [
            'type' => 'auto',
            'matched_slot' => $preferredSlot,
        ];
        
        $duration_json = json_encode($duration);

        $booking = Booking::create([
            'playpal_id' => $playpal->id,
            'parent_id' => $parent->id,
            'status' => 'confirmed',
            'amount' => $amount,
            'paid_at' => Carbon::now(),
            'duration' => $duration_json,
        ]);

        return redirect()->route('playpal.payment.success');
    }

    public function myBookings()
    {
        $playpal = Auth::user()->playPal;
        if (!$playpal) {
            return redirect()->route('playpal.dashboard')->with('error', 'No parent profile found.');
        }
        $bookings = Booking::with('parent.user')->where('playpal_id', $playpal->id)->latest()->get();
        return view('playpal.my-bookings', compact('bookings'));
    }


    public function show($id)
    {
        $booking = Booking::with(['playpal.user', 'parent.user'])->findOrFail($id);

        // Ensure the booking belongs to the current user
        if ($booking->playpal_id !== Auth::user()->playPal->id) {
            abort(403, 'Unauthorized');
        }

        if ($booking->status !== 'accepted' && $booking->status !== 'completed') {
            abort(403, 'Unauthorized: Booking is not accepted.');
        }

        return view('playpal.booking-details', compact('booking'));
    }
}
