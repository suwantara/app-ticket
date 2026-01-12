<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return redirect()->route('staff.login');
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Account is not active'], 403);
            }
            return redirect()->route('staff.login')->with('error', 'Akun Anda tidak aktif');
        }

        if (!$user->isStaff()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Access denied'], 403);
            }
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}
