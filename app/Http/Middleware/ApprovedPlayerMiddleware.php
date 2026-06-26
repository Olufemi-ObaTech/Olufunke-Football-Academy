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

        // Approved players, guardians, and coaches all get access
        if (in_array($user->role, ['player', 'guardian', 'coach']) && $user->isApproved()) {
            return $next($request);
        }

        $dashboardUrl = route('dashboard');

        // Prevent redirect loop
        if ($request->url() === $dashboardUrl || $request->url() === route('home')) {
            abort(403, 'Access denied.');
        }

        if ($user->status === 'pending') {
            return redirect($dashboardUrl)->with('error', 'Your account is pending admin approval. You will be notified once approved.');
        }

        return redirect($dashboardUrl)->with('error', 'Access denied. Contact the academy admin for access.');
    }
}
