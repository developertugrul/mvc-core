<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Application\Middleware\AdminMiddleware;
use App\Core\Request;
use App\Core\Response;

final class AdminMiddlewareTest extends TestCase
{
    public function testAdminMiddlewareBlocksNonAdmin(): void
    {
        $_SESSION = ['user_id' => 1, 'role' => 'user'];
        $middleware = new AdminMiddleware();
        $response = $middleware->handle(new Request('GET', '/admin/dashboard', [], [], [], []), fn () => new Response('ok'));
        self::assertSame(403, $response->statusCode());
    }
}
