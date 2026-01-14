<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ThrottleRequests
{
    /**
     * Rate limit configurations per route type
     */
    protected array $limits = [
        'api' => ['attempts' => 60, 'decay' => 60],      // 60 requests per minute for API
        'web' => ['attempts' => 100, 'decay' => 60],     // 100 requests per minute for web
        'booking' => ['attempts' => 10, 'decay' => 60],  // 10 bookings per minute
        'payment' => ['attempts' => 5, 'decay' => 60],   // 5 payment attempts per minute
        'search' => ['attempts' => 30, 'decay' => 60],   // 30 searches per minute
    ];

    /**
     * Handle an incoming request with rate limiting.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $type = 'web'): Response
    {
        $key = $this->resolveRequestSignature($request, $type);
        $limit = $this->limits[$type] ?? $this->limits['web'];

        if (RateLimiter::tooManyAttempts($key, $limit['attempts'])) {
            return $this->buildTooManyAttemptsResponse($key, $limit['attempts']);
        }

        RateLimiter::hit($key, $limit['decay']);

        $response = $next($request);

        return $this->addHeaders(
            $response,
            $limit['attempts'],
            RateLimiter::remaining($key, $limit['attempts'])
        );
    }

    /**
     * Resolve the request signature for rate limiting.
     */
    protected function resolveRequestSignature(Request $request, string $type): string
    {
        // Use IP + user ID (if authenticated) + route name
        $identifier = $request->user()?->id ?? $request->ip();
        $route = $request->route()?->getName() ?? $request->path();

        return sha1("{$type}:{$identifier}:{$route}");
    }

    /**
     * Build the response for too many attempts.
     */
    protected function buildTooManyAttemptsResponse(string $key, int $maxAttempts): Response
    {
        $retryAfter = RateLimiter::availableIn($key);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.',
                'retry_after' => $retryAfter,
            ], 429)->withHeaders([
                'Retry-After' => $retryAfter,
                'X-RateLimit-Limit' => $maxAttempts,
                'X-RateLimit-Remaining' => 0,
            ]);
        }

        return response()->view('errors.429', [
            'retryAfter' => $retryAfter,
        ], 429)->withHeaders([
            'Retry-After' => $retryAfter,
        ]);
    }

    /**
     * Add rate limit headers to the response.
     */
    protected function addHeaders(Response $response, int $maxAttempts, int $remainingAttempts): Response
    {
        $response->headers->add([
            'X-RateLimit-Limit' => $maxAttempts,
            'X-RateLimit-Remaining' => max(0, $remainingAttempts),
        ]);

        return $response;
    }
}
