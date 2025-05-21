<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarebuddyController extends Controller
{
    // Controller uses middleware via the routes.php file
    // No need for constructor middleware definition here

    public function dashboard()
    {
        // Ensure only carebuddy users can access
        if (!Auth::user() || !Auth::user()->isCareBuddy()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $carebuddy = $user->careBuddy;
        
        return view('carebuddy.dashboard', [
            'user' => $user,
            'carebuddy' => $carebuddy
        ]);
    }
}
