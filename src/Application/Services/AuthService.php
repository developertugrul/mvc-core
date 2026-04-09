<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Repositories\UserRepository;
use App\Core\Auth;
use App\Core\Events\EventDispatcher;

final class AuthService
{
    public function __construct(
        private UserRepository $users,
        private EventDispatcher $events
    )
    {
    }

    public function register(string $name, string $email, string $password): int
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $id = $this->users->create($name, $email, $hash);
        $this->events->dispatch('user.registered', ['id' => $id, 'name' => $name, 'email' => $email]);
        return $id;
    }

    public function attempt(string $email, string $password): bool
    {
        return Auth::attempt($this->users, $email, $password);
    }
}
