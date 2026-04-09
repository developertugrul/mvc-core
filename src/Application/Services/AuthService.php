<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Repositories\UserRepository;
use App\Core\Auth;

final class AuthService
{
    public function __construct(private UserRepository $users)
    {
    }

    public function register(string $name, string $email, string $password): int
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $this->users->create($name, $email, $hash);
    }

    public function attempt(string $email, string $password): bool
    {
        return Auth::attempt($this->users, $email, $password);
    }
}
