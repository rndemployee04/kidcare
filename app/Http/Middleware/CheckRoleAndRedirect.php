<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRoleAndRedirect
{
    /**
     * Handle an incoming request and determine the appropriate redirection based on user role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        Log::info('CheckRoleAndRedirect middleware processing for user', [
            'user_id' => $user->id,
            'role' => $user->role,
            'registration_complete' => $user->registration_complete,
            'verification_status' => $user->verification_status
        ]);

        // Determine the appropriate dashboard based on user role
        if ($user->role === 'admin') {
            // Admin has no extra middlewares, just redirect to admin dashboard
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'carebuddy') {
            // Check if registration is completed for carebuddy
            if (!$user->registration_complete) {
                // If user just registered, send them to the registration form
                if ($request->routeIs('carebuddy.register')) {
                    return $next($request);
                }
                return redirect()->route('carebuddy.registration.incomplete');
            }
            
            // Check verification status for carebuddy
            if ($user->verification_status !== 'approved') {
                // If already on application status page, allow that
                if ($request->routeIs('carebuddy.application.status')) {
                    return $next($request);
                }
                return redirect()->route('carebuddy.application.status');
            }
            
            // Registration complete and verified - go to dashboard
            return redirect()->route('carebuddy.dashboard');
        } elseif ($user->role === 'parent') {
            // Check if registration is completed for parent
            if (!$user->registration_complete) {
                // If user just registered, send them to the registration form
                if ($request->routeIs('parent.register')) {
                    return $next($request);
                }
                return redirect()->route('parent.registration.incomplete');
            }
            
            // Check verification status for parent
            if ($user->verification_status !== 'approved') {
                // If already on application status page, allow that
                if ($request->routeIs('parent.application.status')) {
                    return $next($request);
                }
                return redirect()->route('parent.application.status');
            }
            
            // Registration complete and verified - go to dashboard
            return redirect()->route('parent.dashboard');
        }

        // If no specific role matches, continue with the request
        Log::warning('User with unrecognized role passed through role redirect middleware', [
            'user_id' => $user->id,
            'role' => $user->role
        ]);
        return $next($request);
    }
}
