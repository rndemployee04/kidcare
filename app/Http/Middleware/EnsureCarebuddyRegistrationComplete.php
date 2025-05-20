<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureCarebuddyRegistrationComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'carebuddy') {
            abort(403, 'Unauthorized. Only carebuddy users allowed.');
        }
        if (!$user->registration_complete) {
            return redirect()->route('carebuddy.registration.incomplete');
        }
        return $next($request);
    }
}
