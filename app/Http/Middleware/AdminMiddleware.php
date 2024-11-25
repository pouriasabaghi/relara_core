<?php

namespace App\Http\Middleware;

use App\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && in_array($request->user()->role, [UserRole::Admin->value, UserRole::Developer->value]))
            return $next($request);

        return response()->json([
            'message' => 'Access denied',
            'success' => false,
        ], Response::HTTP_FORBIDDEN);
    }
}
