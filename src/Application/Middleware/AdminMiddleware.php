<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Core\Auth;
use App\Core\MiddlewareInterface;
use App\Core\Request;
use App\Core\Response;

final class AdminMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        if (!Auth::check() || !Auth::hasRole('admin')) {
            return new Response('Forbidden', 403);
        }

        return $next($request);
    }
}
