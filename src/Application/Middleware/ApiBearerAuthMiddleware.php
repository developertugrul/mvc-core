<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Application\Services\OAuthService;
use App\Core\MiddlewareInterface;
use App\Core\Request;
use App\Core\Response;

final class ApiBearerAuthMiddleware implements MiddlewareInterface
{
    public function __construct(private OAuthService $oauth)
    {
    }

    public function handle(Request $request, callable $next): Response
    {
        $header = (string) ($request->server['HTTP_AUTHORIZATION'] ?? '');
        if (!str_starts_with($header, 'Bearer ')) {
            return Response::json(['error' => 'unauthorized'], 401);
        }

        $token = trim(substr($header, 7));
        $row = $this->oauth->validateBearer($token);
        if ($row === null) {
            return Response::json(['error' => 'invalid_token'], 401);
        }

        $request = $request
            ->withAttribute('oauth_client_id', (string) $row['client_id'])
            ->withAttribute('oauth_user_id', isset($row['user_id']) ? (int) $row['user_id'] : null)
            ->withAttribute('oauth_scope', (string) ($row['scope'] ?? ''));

        return $next($request);
    }
}
