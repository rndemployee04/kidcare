<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminVerified
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            abort(403, 'Unauthorized. Only admin users allowed.');
        }
        if ($user->verification_status !== 'approved') {
            return redirect()->route('admin.application.status');
        }
        return $next($request);
    }
}
