<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureCarebuddyVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'carebuddy') {
            abort(403, 'Unauthorized. Only carebuddy users allowed.');
        }
        if ($user->verification_status !== 'approved') {
            return redirect()->route('carebuddy.application.status');
        }
        return $next($request);
    }
}
