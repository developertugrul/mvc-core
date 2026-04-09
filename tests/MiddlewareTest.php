<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Application\Middleware\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;

final class MiddlewareTest extends TestCase
{
    public function testAuthMiddlewareRedirectsGuest(): void
    {
        $_SESSION = [];
        $middleware = new AuthMiddleware();
        $request = new Request('GET', '/dashboard', [], [], [], []);
        $response = $middleware->handle($request, fn () => new Response('ok'));
        self::assertSame(302, $response->statusCode());
    }
}
