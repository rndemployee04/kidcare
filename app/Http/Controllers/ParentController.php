<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CareBuddy;
use Illuminate\Support\Facades\Session;

class ParentController extends Controller
{
    // Controller uses middleware via the routes.php file
    // No need for constructor middleware definition here

    public function dashboard()
    {
        // Ensure only parent users can access
        if (!Auth::user() || !Auth::user()->isParent()) {
            abort(403, 'Unauthorized');
        }

        $parent = Auth::user()->parentProfile;
        $booking = Booking::where('parent_id', Auth::user()->parentProfile->id)->latest()->first();

        $type = '';
        $status = $booking->status ?? 'none';
        $dismissedKey = 'booking_dismissed_' . ($booking->id ?? 'none') . '_' . $status;

        if ($booking && !session()->has($dismissedKey)) {
            if ($booking->status === 'accepted') {
                $type = 'success';
                session()->flash('booking', 'Your booking has been accepted!');
                session()->flash('alertType', $type);
            } elseif ($booking->status === 'rejected') {
                $type = 'error';
                $careBuddyName = optional($booking->careBuddy->user)->name ?? 'CareBuddy';
                $message = "Your booking #{$booking->id} was cancelled by {$careBuddyName}. Your payment will be refunded shortly.";
                session()->flash('booking', $message);
                session()->flash('alertType', $type);
            }
        }

        $cancelKey = 'parent_' . $parent->id . '_booking_cancelled';
        if (Session::has($cancelKey)) {
            $cancelData = Session::get($cancelKey);
            session()->flash('booking', $cancelData['message']);
            session()->flash('alertType', $cancelData['type'] ?? 'error');
            Session::forget($cancelKey);
        }

        // Get statistics
        $activeBookings = $parent->bookings()->where('status', 'confirmed')->count();
        $completedBookings = $parent->bookings()->where('status', 'accepted')->count();
        return view('parent.dashboard', compact('activeBookings', 'completedBookings'))->with('dismissedKey', $dismissedKey);
    }
}
