<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Session;

class PlayPalController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $playpal = $user->playPal;
        $booking = Booking::where('parent_id', Auth::user()->playPal->id)->latest()->first();

        if (!Auth::user() || !Auth::user()->isPlayPal()) {
            abort(403, 'Unauthorized');
        }

        $type = '';
        $status = $booking->status ?? 'none';
        $dismissedKey = 'booking_dismissed_' . ($booking->id ?? 'none') . '_' . $status;

        if ($booking && !session()->has($dismissedKey)) {
            if ($booking->status === 'accepted') {
                $type = 'success';
                $parentName = optional($booking->parent->user)->name ?? 'Parent';
                $message = "Your booking #{$booking->id} has been accepted by {$parentName}.";
                session()->flash('booking', $message);
                session()->flash('alertType', $type);
            } elseif ($booking->status === 'rejected') {
                $type = 'error';
                $parentName = optional($booking->parent->user)->name ?? 'Parent';
                $message = "Your booking #{$booking->id} was cancelled by {$parentName}. Your payment will be refunded shortly.";
                session()->flash('booking', $message);
                session()->flash('alertType', $type);
            }
        }

        $cancelKey = 'playpal_' . $playpal->id . '_booking_cancelled';
        if (Session::has($cancelKey)) {
            $cancelData = Session::get($cancelKey);
            session()->flash('booking', $cancelData['message']);
            session()->flash('alertType', $cancelData['type'] ?? 'error');
            Session::forget($cancelKey);
        }

        $bookings = Booking::with('parent.user')
            ->where('playpal_id', $playpal->id)
            ->latest()
            ->get();


        return view('playpal.dashboard', [
            'bookings' => $bookings,
            'playpal' => $playpal,
            'user' => $user,
        ])->with('dismissedKey', $dismissedKey);
    }
}
