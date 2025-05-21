<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureParentVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'parent') {
            abort(403, 'Unauthorized. Only parent users allowed.');
        }
        if ($user->verification_status !== 'approved') {
            return redirect()->route('parent.application.status');
        }
        return $next($request);
    }
}
