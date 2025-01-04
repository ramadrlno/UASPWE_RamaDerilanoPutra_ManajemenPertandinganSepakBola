<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     * @param  string $userType
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $userType): Response
    {
        if (Auth::check() && Auth::user()->role == $userType) {
            return $next($request);
        }

        return response()->json([
            'error' => 'You do not have permission to access this page.',
            'userType' => $userType,
        ], Response::HTTP_FORBIDDEN);
    }
}
