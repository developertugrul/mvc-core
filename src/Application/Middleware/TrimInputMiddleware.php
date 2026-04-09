<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Core\MiddlewareInterface;
use App\Core\Request;
use App\Core\Response;

final class TrimInputMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        foreach ($_POST as $key => $value) {
            if (is_string($value)) {
                $_POST[$key] = trim($value);
            }
        }

        return $next($request);
    }
}
