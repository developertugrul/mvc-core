<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Core\MiddlewareInterface;
use App\Core\Request;
use App\Core\Response;

final class RateLimitMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        $key = 'rate:' . ($request->server['REMOTE_ADDR'] ?? 'cli');
        $bucket = $_SESSION[$key] ?? ['count' => 0, 'time' => time()];
        if (time() - $bucket['time'] > 60) {
            $bucket = ['count' => 0, 'time' => time()];
        }
        $bucket['count']++;
        $_SESSION[$key] = $bucket;

        if ($bucket['count'] > 120) {
            return new Response('Too Many Requests', 429);
        }
        return $next($request);
    }
}
