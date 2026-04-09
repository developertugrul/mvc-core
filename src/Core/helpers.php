<?php

declare(strict_types=1);

use App\Core\Config;
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
