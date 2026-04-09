<?php

declare(strict_types=1);

namespace App\Application\Components;

use App\Core\Component\Component;

final class LanguageSwitcherComponent extends Component
{
    public function render(): string
    {
        $active = (string) ($_SESSION['locale'] ?? 'tr');
        return '<div class="flex gap-2"><a class="px-2 py-1 border rounded" href="/tr">TR</a><a class="px-2 py-1 border rounded" href="/en">EN</a><span class="text-sm text-gray-600">active: ' . htmlspecialchars($active, ENT_QUOTES, 'UTF-8') . '</span></div>';
    }
}
