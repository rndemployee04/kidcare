<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePlayPalRegistrationComplete
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'playpal') {
            abort(403, 'Unauthorized. Only playpal users allowed.');
        }
        if (!$user->registration_complete) {
            return redirect()->route('playpal.registration.incomplete');
        }
        return $next($request);
    }
}
