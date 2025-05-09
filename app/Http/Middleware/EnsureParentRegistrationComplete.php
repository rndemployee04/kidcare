<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureParentRegistrationComplete
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user && $user->isParent() && !$user->registration_complete) {
            return redirect()->route('parent.registration.incomplete');
        }
        return $next($request);
    }
}
