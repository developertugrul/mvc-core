<?php

declare(strict_types=1);

namespace App\Core\Component;

final class ComponentManager
{
    public function __construct(
        private ComponentRegistry $registry,
        private ComponentSigner $signer
    ) {
    }

    /** @param array<string, mixed> $props */
    public function render(string $alias, array $props = []): string
    {
        $component = $this->registry->make($alias);
        if ($component === null) {
            return '<!-- component not found: ' . htmlspecialchars($alias, ENT_QUOTES, 'UTF-8') . ' -->';
        }

        $component->mount($props);
        $payload = json_encode(['name' => $alias, 'state' => $component->state()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';
        $signature = $this->signer->sign($payload);

        return '<div data-component="' . htmlspecialchars($alias, ENT_QUOTES, 'UTF-8') . '" data-payload="' .
            htmlspecialchars(base64_encode($payload), ENT_QUOTES, 'UTF-8') . '" data-signature="' .
            htmlspecialchars($signature, ENT_QUOTES, 'UTF-8') . '">' . $component->render() . '</div>';
    }
}
