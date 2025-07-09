<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsurePlayPalVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'playpal') {
            abort(403, 'Unauthorized. Only playpal users allowed.');
        }
        if ($user->verification_status !== 'approved') {
            return redirect()->route('playpal.application.status');
        }
        return $next($request);
    }
}
