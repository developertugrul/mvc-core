<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Policies\UserPolicy;
use App\Core\Auth;
use App\Core\Gate;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;

final class DashboardController
{
    public function __construct(private UserPolicy $policy)
    {
    }

    public function index(Request $request): Response
    {
        Gate::define('view-admin-dashboard', fn (string $role): bool => $this->policy->viewAdminDashboard($role));

        return View::render('dashboard', [
            'role' => Auth::role(),
            'canViewAdmin' => Gate::allows('view-admin-dashboard', Auth::role()),
        ]);
    }
}
