<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Application\Policies\UserPolicy;

final class PolicyTest extends TestCase
{
    public function testAdminCanViewAdminDashboard(): void
    {
        $policy = new UserPolicy();
        self::assertTrue($policy->viewAdminDashboard('admin'));
    }

    public function testUserCannotViewAdminDashboard(): void
    {
        $policy = new UserPolicy();
        self::assertFalse($policy->viewAdminDashboard('user'));
    }
}
