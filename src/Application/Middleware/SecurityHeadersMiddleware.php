<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Core\MiddlewareInterface;
use App\Core\Request;
use App\Core\Response;

final class SecurityHeadersMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        $response = $next($request);
        return $response->withHeaders([
            'X-Frame-Options' => 'SAMEORIGIN',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Content-Security-Policy' => "default-src 'self'",
        ]);
    }
}
