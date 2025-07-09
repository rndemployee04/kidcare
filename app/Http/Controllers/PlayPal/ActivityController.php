<?php

namespace App\Http\Controllers\PlayPal;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $playpal = $user->playPal; // Assumes User model has playPal() relationship
        // Replace with actual PlayPal activity data fetch
        $activities = [];
        return view('playpal.activity', compact('user', 'playpal', 'activities'));
    }
}
