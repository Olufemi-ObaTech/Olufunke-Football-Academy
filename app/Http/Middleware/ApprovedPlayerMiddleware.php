<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApprovedPlayerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        // Admins always have access to everything
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Approved players have full access
        if ($user->role === 'player' && $user->isApproved()) {
            return $next($request);
        }

        // Pending or rejected players — send to dashboard (which is NOT behind this middleware)
        // Use home route as fallback if dashboard somehow loops
        $fallback = route('home');
        $dashboardUrl = route('dashboard');

        // Prevent redirect loop: if already heading to dashboard or home, just abort
        if ($request->url() === $dashboardUrl || $request->url() === $fallback) {
            abort(403, 'Access denied.');
        }

        if ($user->role === 'player' && $user->status === 'pending') {
            return redirect($dashboardUrl)->with('error', 'Your account is pending approval. You\'ll be notified once approved.');
        }

        return redirect($dashboardUrl)->with('error', 'Access denied. Your account may have been rejected.');
    }
}
