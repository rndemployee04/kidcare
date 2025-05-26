<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarebuddyProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $carebuddy = $user->careBuddy;
        return view('carebuddy.profile', compact('user', 'carebuddy'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $carebuddy = $user->careBuddy;

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Only allow a few fields to be updated
        if (isset($validated['phone'])) {
            $carebuddy->phone = $validated['phone'];
        }
        if (isset($validated['city'])) {
            $carebuddy->city = $validated['city'];
        }
        if (isset($validated['state'])) {
            $carebuddy->state = $validated['state'];
        }
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $carebuddy->profile_photo = $path;
        }
        $carebuddy->save();

        return redirect()->route('carebuddy.profile.show')->with('success', 'Profile updated successfully!');
    }
}
