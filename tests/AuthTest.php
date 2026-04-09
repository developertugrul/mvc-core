<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Core\Auth;

final class AuthTest extends TestCase
{
    protected function setUp(): void
    {
        $_SESSION = [];
    }

    public function testAuthCheckReturnsFalseWithoutSession(): void
    {
        self::assertFalse(Auth::check());
    }

    public function testAuthCheckReturnsTrueWithSession(): void
    {
        $_SESSION['user_id'] = 1;
        self::assertTrue(Auth::check());
    }
}
