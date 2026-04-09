<?php

declare(strict_types=1);

namespace App\Core;

final class Session
{
    public static function boot(Config $config): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            return;
        }

        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'secure' => (bool) $config->get('session_secure_cookie', false),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        session_start();
    }
}
