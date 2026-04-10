<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Let op: ...$roles is een variadische parameter en moet zo geschreven worden met drie puntjes!!!

        $user = Auth::user();

        if (!$user) {
            // niet ingelogd: naar login
            return redirect()->route('login');
        }

        $userRole = strtolower($user->rolename ?? '');

        if (!in_array($userRole, $roles, true)) {
            abort(403, 'Onvoldoende rechten.');
        }

        return $next($request);
    }
}