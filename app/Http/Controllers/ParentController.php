<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Child;
use Illuminate\Support\Facades\Auth;

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

        // Get statistics
        $activeBookings = $parent->bookings()->where('status', 'confirmed')->orWhere('status', 'accepted')->count();
        $completedBookings = $parent->bookings()->where('status', 'completed')->count();

        $bookings = Booking::with('parent.user')
            ->where('parent_id', $parent->id)
            ->where('status', 'confirmed')
            ->latest()
            ->get();

        $data = [
            'activeBookings' => $activeBookings,
            'completedBookings' => $completedBookings,
            'bookings' => $bookings
        ];

        return view('parent.dashboard', $data);
    }



    public function children()
    {   
        $user = Auth::user();
        $children = Child::where('parent_id',$user->parentProfile->id)->get();
        return view('parent.children.index', compact('children'));
    }
}
