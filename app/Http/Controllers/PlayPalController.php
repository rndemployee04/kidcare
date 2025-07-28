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
        \Log::info('DASHBOARD DEBUG', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'playpal_id' => $playpal ? $playpal->id : null,
            'playpal_user_id' => $playpal ? $playpal->user_id : null,
        ]);
        $booking = Booking::where('playpal_id', $playpal->id)->latest()->first();
        if ($booking) {
            \Log::info('DASHBOARD BOOKING', [
                'booking_id' => $booking->id,
                'booking_playpal_id' => $booking->playpal_id,
                'booking_status' => $booking->status,
                'booking_parent_id' => $booking->parent_id,
            ]);
        } else {
            \Log::info('DASHBOARD BOOKING', ['booking' => null]);
        }

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
                session()->flash('booking_' . $playpal->id, $message);
                session()->flash('alertType_' . $playpal->id, $type);
            } elseif ($booking->status === 'rejected') {
                $type = 'error';
                $parentName = optional($booking->parent->user)->name ?? 'Parent';
                $message = "Your booking #{$booking->id} was cancelled by {$parentName}. Your payment will be refunded shortly.";
                session()->flash('booking_' . $playpal->id, $message);
                session()->flash('alertType_' . $playpal->id, $type);
            }
        }

        $cancelKey = 'playpal_' . $playpal->id . '_booking_cancelled';
        if (Session::has($cancelKey)) {
            $cancelData = Session::get($cancelKey);
            session()->flash('booking_' . $playpal->id, $cancelData['message']);
            session()->flash('alertType_' . $playpal->id, $cancelData['type'] ?? 'error');
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
