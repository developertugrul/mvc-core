<?php

declare(strict_types=1);

use App\Core\Config;
use App\Core\Component\ComponentManager;
use App\Core\I18n;

if (!function_exists('__')) {
    function __(string $key, array $replace = []): string
    {
        global $appConfig;
        if (!$appConfig instanceof Config) {
            return $key;
        }
        return I18n::trans($key, $appConfig, $replace);
    }
}

if (!function_exists('component')) {
    /** @param array<string, mixed> $props */
    function component(string $name, array $props = []): string
    {
        global $appContainer;
        if (!$appContainer) {
            return '';
        }

        /** @var ComponentManager $manager */
        $manager = $appContainer->get(ComponentManager::class);
        return $manager->render($name, $props);
    }
}
