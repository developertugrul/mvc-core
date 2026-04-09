<?php

declare(strict_types=1);

namespace App\Application\Policies;

final class UserPolicy
{
    public function viewAdminDashboard(string $role): bool
    {
        return $role === 'admin';
    }
}
