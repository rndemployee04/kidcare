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
        \Log::info('Booking POST hit!', ['user_id' => \Auth::id(), 'carebuddy_id' => $carebuddyId]);
        $user = Auth::user();
        // Role and relationship check
        if (!$user->isParent() || !$user->parentProfile) {
            return redirect()->back()->with('error', 'You must be logged in as a parent with a complete profile to book a carebuddy.');
        }
        $parent = $user->parentProfile;
        $carebuddy = \App\Models\CareBuddy::findOrFail($carebuddyId);
        $amount = $request->input('amount', 500); // default amount

        // Prevent double booking
        $existing = \App\Models\Booking::where('carebuddy_id', $carebuddy->id)
            ->where('parent_id', $parent->id)
            ->first();
        if ($existing) {
            return redirect()->back()->with('error', 'You have already booked this carebuddy.');
        }

        $duration = $request->input('duration');
        
        $booking = \App\Models\Booking::create([
            'carebuddy_id' => $carebuddy->id,
            'parent_id' => $parent->id,
            'status' => 'confirmed',
            'amount' => $amount,
            'paid_at' => \Carbon\Carbon::now(),
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
        $booking = Booking::with(['carebuddy.user', 'parent.user'])->findOrFail($id);
        
        // Ensure the booking belongs to the current user
        if ($booking->parent_id !== Auth::user()->parentProfile->id) {
            abort(403, 'Unauthorized');
        }

        return view('parent.booking-details', compact('booking'));
    }
}
