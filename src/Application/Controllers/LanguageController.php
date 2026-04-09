<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Core\Config;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;

final class LanguageController
{
    public function __construct(private Config $config)
    {
    }

    public function settings(Request $request): Response
    {
        return View::render('settings/language', [
            'csrfToken' => Csrf::token(),
            'enabled' => $_SESSION['enabled_locales'] ?? $this->config->get('enabled_locales', ['tr', 'en']),
            'allLocales' => ['tr', 'en'],
        ]);
    }

    public function update(Request $request): Response
    {
        $enabled = $request->body['enabled_locales'] ?? ['tr', 'en'];
        if (!is_array($enabled) || $enabled === []) {
            $enabled = [$this->config->get('default_locale', 'tr')];
        }

        $enabled = array_values(array_intersect(['tr', 'en'], array_map('strval', $enabled)));
        $_SESSION['enabled_locales'] = $enabled;
        $_SESSION['locale'] = in_array((string) ($_SESSION['locale'] ?? ''), $enabled, true) ? $_SESSION['locale'] : $enabled[0];

        return Response::redirect('/settings/language');
    }
}
