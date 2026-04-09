<?php

declare(strict_types=1);

use App\Application\Controllers\OAuthController;
use App\Application\Middleware\ApiBearerAuthMiddleware;
use App\Application\Middleware\RateLimitMiddleware;
use App\Application\Middleware\SecurityHeadersMiddleware;

return [
    ['method' => 'POST', 'uri' => '/oauth/token', 'handler' => [OAuthController::class, 'token'], 'middleware' => [SecurityHeadersMiddleware::class, RateLimitMiddleware::class]],
    ['method' => 'GET', 'uri' => '/api/me', 'handler' => [OAuthController::class, 'me'], 'middleware' => [SecurityHeadersMiddleware::class, RateLimitMiddleware::class, ApiBearerAuthMiddleware::class]],
];
