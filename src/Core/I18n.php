<?php

declare(strict_types=1);

namespace App\Core;

final class I18n
{
    private static string $locale = 'tr';
    /** @var array<string, array<string, mixed>> */
    private static array $catalog = [];

    public static function setLocale(string $locale, Config $config): void
    {
        $enabled = $config->get('enabled_locales', ['tr', 'en']);
        self::$locale = in_array($locale, $enabled, true) ? $locale : (string) $config->get('default_locale', 'tr');
    }

    public static function locale(): string
    {
        return self::$locale;
    }

    public static function trans(string $key, Config $config, array $replace = []): string
    {
        [$file, $item] = array_pad(explode('.', $key, 2), 2, '');
        if (!isset(self::$catalog[self::$locale][$file])) {
            $path = $config->basePath('lang/' . self::$locale . '/' . $file . '.php');
            self::$catalog[self::$locale][$file] = file_exists($path) ? (array) require $path : [];
        }

        $value = (string) (self::$catalog[self::$locale][$file][$item] ?? $key);
        foreach ($replace as $k => $v) {
            $value = str_replace(':' . $k, (string) $v, $value);
        }
        return $value;
    }
}
