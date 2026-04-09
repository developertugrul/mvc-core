<?php

declare(strict_types=1);

namespace App\Core;

use Monolog\Logger;
use Throwable;

final class ErrorHandler
{
    public static function register(Logger $logger, bool $debug): void
    {
        set_exception_handler(static function (Throwable $exception) use ($logger, $debug): void {
            $logger->error($exception->getMessage(), ['trace' => $exception->getTraceAsString()]);
            http_response_code(500);
            echo $debug ? nl2br(htmlspecialchars((string) $exception)) : 'Server Error';
        });
    }
}
