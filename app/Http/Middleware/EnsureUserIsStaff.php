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
        $deniedResponse = $this->validateAccess($request);

        if ($deniedResponse !== null) {
            return $deniedResponse;
        }

        return $next($request);
    }

    private function validateAccess(Request $request): ?Response
    {
        if (! Auth::check()) {
            return $this->unauthorizedResponse($request);
        }

        $user = Auth::user();

        if (! $user->is_active) {
            Auth::logout();

            return $this->inactiveAccountResponse($request);
        }

        return $user->isStaff() ? null : $this->accessDeniedResponse($request);
    }

    private function unauthorizedResponse(Request $request): Response
    {
        return $request->expectsJson()
            ? response()->json(['message' => 'Unauthorized'], 401)
            : redirect()->route('staff.login');
    }

    private function inactiveAccountResponse(Request $request): Response
    {
        return $request->expectsJson()
            ? response()->json(['message' => 'Account is not active'], 403)
            : redirect()->route('staff.login')->with('error', 'Akun Anda tidak aktif');
    }

    private function accessDeniedResponse(Request $request): Response
    {
        return $request->expectsJson()
            ? response()->json(['message' => 'Access denied'], 403)
            : redirect()->route('home')->with('error', 'Anda tidak memiliki akses ke halaman ini');
    }
}
