<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Core\Csrf;
use App\Core\MiddlewareInterface;
use App\Core\Request;
use App\Core\Response;

final class CsrfMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        if ($request->method === 'POST') {
            $token = (string) $request->input('_csrf', '');
            if (!Csrf::verify($token)) {
                return new Response('Invalid CSRF token', 419);
            }
        }
        return $next($request);
    }
}
