<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Core\Config;
use App\Core\I18n;
use App\Core\MiddlewareInterface;
use App\Core\Request;
use App\Core\Response;

final class LocaleMiddleware implements MiddlewareInterface
{
    public function __construct(private Config $config)
    {
    }

    public function handle(Request $request, callable $next): Response
    {
        $locale = (string) $request->attribute('locale', $_SESSION['locale'] ?? $this->config->get('default_locale', 'tr'));
        I18n::setLocale($locale, $this->config);
        $_SESSION['locale'] = I18n::locale();
        return $next($request);
    }
}
