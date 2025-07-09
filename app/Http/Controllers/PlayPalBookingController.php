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
            'duration_type' => 'required',
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
            ->where('status','!=' ,'completed')
            ->first();
        if ($existing) {
            return redirect()->back()->with('error', 'You have already booked this parent.');
        }

        $durationType = $request->input('duration_type');
        $duration = ['type' => $durationType];

        if ($durationType === 'time') {
            $duration['start'] = $request->input('time_start');
            $duration['hours'] = $request->input('time_hours');
        } elseif ($durationType === 'date') {
            $duration['start'] = $request->input('date_start');
            $duration['end'] = $request->input('date_end');
        } elseif ($durationType === 'week') {
            $duration['week'] = $request->input('duration_week');
        }

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
