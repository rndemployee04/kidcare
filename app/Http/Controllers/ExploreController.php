<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CareBuddy;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    /**
     * Display the explore page with carebuddies.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = CareBuddy::with('user')
            ->whereHas('user', function ($query) {
                $query->where('verification_status', 'approved');
            });

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        // Location filter
        if ($request->has('location') && !empty($request->location)) {
            $query->where('city', $request->location);
        }

        // Radius filter
        if ($request->has('radius') && !empty($request->radius)) {
            $radius = explode('-', $request->radius);
            if (count($radius) === 2) {
                // Filter carebuddies whose service radius is at least the minimum selected
                $minRadius = (int)$radius[0];
                $query->where('service_radius', '>=', $minRadius);
            }
        }

        // Child age filter
        if ($request->has('child_age') && !empty($request->child_age) && $request->child_age !== 'all') {
            $childAge = $request->child_age;
            // Using child_age_limit field which stores the maximum age the carebuddy can handle
            $query->where('child_age_limit', '>=', (int)explode('-', $childAge)[1]);
        }

        // Category filter
        if ($request->has('category') && $request->category !== 'any') {
            $query->where('category', $request->category);
        }

        // Gender filter
        if ($request->has('gender') && $request->gender !== 'any') {
            $query->where('gender', $request->gender);
        }

        // Availability filter
        if ($request->has('availability') && is_array($request->availability) && count($request->availability) > 0) {
            $query->where(function($q) use ($request) {
                foreach ($request->availability as $slot) {
                    $q->orWhereJsonContains('availability', $slot);
                }
            });
        }

        $carebuddies = $query->paginate(8);

        return view('explore', [
            'carebuddies' => $carebuddies,
            'filters' => $request->only(['search', 'location', 'radius', 'child_age', 'category', 'gender', 'availability'])
        ]);
    }

    /**
     * Show a specific carebuddy's profile.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $carebuddy = CareBuddy::with('user')->findOrFail($id);

        if (!$carebuddy->user || $carebuddy->user->verification_status !== 'approved') {
            abort(404, 'Carebuddy not found');
        }

        $alreadyBooked = false;
        if (auth()->check() && auth()->user()->parent) {
            $alreadyBooked = Booking::where('carebuddy_id', $carebuddy->id)
                ->where('parent_id', auth()->user()->parent->id)
                ->exists();
        }

        return view('carebuddy-profile', [
            'carebuddy' => $carebuddy,
            'user' => $carebuddy->user,
            'alreadyBooked' => $alreadyBooked
        ]);
    }
}
