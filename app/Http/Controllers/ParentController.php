<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\CareBuddy;

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

        $user = Auth::user();
        $parent = $user->parent;
        
        return view('parent.dashboard', [
            'user' => $user,
            'parent' => $parent
        ]);
    }
}
