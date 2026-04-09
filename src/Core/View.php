<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $template, array $data = []): Response
    {
        $file = BASE_PATH . '/src/Application/Views/' . $template . '.php';
        if (!file_exists($file)) {
            return new Response('View not found', 404);
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $file;
        $content = ob_get_clean() ?: '';

        return new Response($content);
    }
}
