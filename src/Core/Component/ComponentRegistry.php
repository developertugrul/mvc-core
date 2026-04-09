<?php

declare(strict_types=1);

namespace App\Core\Component;

use DI\Container;

final class ComponentRegistry
{
    /** @var array<string, class-string<Component>> */
    private array $map = [];

    public function __construct(private Container $container)
    {
    }

    public function register(string $alias, string $componentClass): void
    {
        $this->map[$alias] = $componentClass;
    }

    public function make(string $alias): ?Component
    {
        if (!isset($this->map[$alias])) {
            return null;
        }
        /** @var Component $component */
        $component = $this->container->get($this->map[$alias]);
        return $component;
    }
}
