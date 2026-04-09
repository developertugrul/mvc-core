<?php

declare(strict_types=1);

namespace App\Core;

use App\Application\Repositories\UserRepository;

final class Auth
{
    public static function id(): ?int
    {
        return isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
    }

    public static function check(): bool
    {
        return self::id() !== null;
    }

    public static function attempt(UserRepository $users, string $email, string $password): bool
    {
        $user = $users->findByEmail($email);
        if ($user === null || !password_verify($password, $user['password_hash'])) {
            return false;
        }

        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['role'] = $user['role'];

        return true;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_regenerate_id(true);
    }

    public static function role(): string
    {
        return (string) ($_SESSION['role'] ?? 'guest');
    }

    public static function hasRole(string $role): bool
    {
        return self::role() === $role;
    }
}
