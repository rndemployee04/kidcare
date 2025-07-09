<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayPalProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $playpal = $user->playPal; // Assumes User model has playPal() relationship
        return view('playpal.profile', compact('user', 'playpal'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $playpal = $user->playPal;

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if (isset($validated['phone'])) {
            $playpal->phone = $validated['phone'];
        }
        if (isset($validated['city'])) {
            $playpal->city = $validated['city'];
        }
        if (isset($validated['state'])) {
            $playpal->state = $validated['state'];
        }
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $playpal->profile_photo = $path;
        }
        $playpal->save();

        return redirect()->route('playpal.profile.show')->with('success', 'Profile updated successfully!');
    }
}
