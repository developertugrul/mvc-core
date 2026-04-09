<?php

declare(strict_types=1);

namespace App\Application\Components;

use App\Core\Component\Component;

final class CounterComponent extends Component
{
    /** @param array<string, mixed> $props */
    public function mount(array $props = []): void
    {
        parent::mount($props);
        $this->state['count'] = (int) ($props['start'] ?? 0);
    }

    /** @param array<string, mixed> $payload */
    public function increment(array $payload = []): void
    {
        $this->state['count'] = ((int) ($this->state['count'] ?? 0)) + 1;
    }

    public function render(): string
    {
        $count = (int) ($this->state['count'] ?? 0);
        return '<div class="p-4 border rounded space-y-2"><p class="font-semibold">Counter: ' . $count . '</p><button type="button" data-component-action="increment" class="px-3 py-1 rounded bg-slate-900 text-white">Increment</button></div>';
    }
}
