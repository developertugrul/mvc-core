<?php

declare(strict_types=1);

namespace App\Core;

final class Gate
{
    /** @var array<string, callable> */
    private static array $policies = [];

    public static function define(string $ability, callable $resolver): void
    {
        self::$policies[$ability] = $resolver;
    }

    public static function allows(string $ability, mixed ...$arguments): bool
    {
        if (!isset(self::$policies[$ability])) {
            return false;
        }

        return (bool) (self::$policies[$ability])(...$arguments);
    }
}
