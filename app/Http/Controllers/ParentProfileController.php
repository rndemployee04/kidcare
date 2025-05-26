<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $parent = $user->parentProfile;
        return view('parent.profile', compact('user', 'parent'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $parent = $user->parentProfile;

        $validated = $request->validate([
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Only allow a few fields to be updated
        if (isset($validated['phone'])) {
            $parent->phone = $validated['phone'];
        }
        if (isset($validated['city'])) {
            $parent->city = $validated['city'];
        }
        if (isset($validated['state'])) {
            $parent->state = $validated['state'];
        }
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $parent->profile_photo = $path;
        }
        $parent->save();

        return redirect()->route('parent.profile.show')->with('success', 'Profile updated successfully!');
    }
}
