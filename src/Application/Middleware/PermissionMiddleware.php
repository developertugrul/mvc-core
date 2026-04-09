<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Core\Auth;
use App\Core\MiddlewareInterface;
use App\Core\Request;
use App\Core\Response;

final class PermissionMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, callable $next): Response
    {
        $required = (string) $request->attribute('permission', '');
        if ($required === '') {
            return $next($request);
        }

        $permissions = $_SESSION['permissions'] ?? [];
        if (!is_array($permissions) || !in_array($required, $permissions, true)) {
            if (!Auth::hasRole('admin')) {
                return new Response('Forbidden', 403);
            }
        }

        return $next($request);
    }
}
