<?php

declare(strict_types=1);

namespace App\Core\Component;

abstract class Component
{
    /** @var array<string, mixed> */
    protected array $state = [];

    /** @param array<string, mixed> $props */
    public function mount(array $props = []): void
    {
        $this->state = $props;
    }

    /** @param array<string, mixed> $state */
    public function hydrate(array $state): void
    {
        $this->state = $state;
    }

    /** @return array<string, mixed> */
    public function state(): array
    {
        return $this->state;
    }

    /** @param array<string, mixed> $payload */
    public function call(string $action, array $payload = []): void
    {
        if (!method_exists($this, $action)) {
            return;
        }
        $this->{$action}($payload);
    }

    abstract public function render(): string;
}
