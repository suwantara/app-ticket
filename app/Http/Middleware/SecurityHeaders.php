<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and add security headers.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only add headers for web responses (not API/JSON)
        if ($response instanceof Response) {
            // Prevent XSS attacks
            $response->headers->set('X-XSS-Protection', '1; mode=block');

            // Prevent MIME type sniffing
            $response->headers->set('X-Content-Type-Options', 'nosniff');

            // Prevent clickjacking
            $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

            // Referrer policy
            $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

            // Permissions Policy (formerly Feature Policy)
            // By default deny sensitive features, but allow camera on boarding pages
            $allowCamera = false;
            try {
                $route = $request->route();
                $routeName = $route?->getName();
                if ($request->is('boarding*') || ($routeName && str_starts_with($routeName, 'boarding.'))) {
                    $allowCamera = true;
                }
            } catch (\Throwable $e) {
                $allowCamera = false;
            }

            $cameraPolicy = $allowCamera ? 'camera=(self)' : 'camera=()';
            $response->headers->set('Permissions-Policy', $cameraPolicy.', microphone=(), geolocation=()');

            // Content Security Policy - Skip in local development to allow Vite HMR
            if (config('app.env') !== 'local') {
                $csp = [
                    "default-src 'self'",
                    "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://app.sandbox.midtrans.com https://app.midtrans.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://kit.fontawesome.com https://ka-f.fontawesome.com https://unpkg.com blob:",
                    "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net https://ka-f.fontawesome.com",
                    "font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com https://ka-f.fontawesome.com",
                    "img-src 'self' data: blob: https:",
                    "media-src 'self' data: blob:",
                    "worker-src 'self' blob:",
                    "connect-src 'self' https://app.sandbox.midtrans.com https://app.midtrans.com https://ka-f.fontawesome.com wss: blob:",
                    "frame-src 'self' https://app.sandbox.midtrans.com https://app.midtrans.com",
                    "object-src 'none'",
                    "base-uri 'self'",
                    "form-action 'self'",
                    "upgrade-insecure-requests",
                ];

                $response->headers->set('Content-Security-Policy', implode('; ', $csp));
            }

            // Strict Transport Security (only in production with HTTPS)
            if (config('app.env') === 'production' && $request->isSecure()) {
                $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
            }
        }

        return $response;
    }
}
