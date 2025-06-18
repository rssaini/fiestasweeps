<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSupervisorOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!($user && ($user->role == 'Supervisor' || $user->role == 'Admin'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized - Supervisor or Admin only',
            ], 403);
        }

        return $next($request);
    }
}
