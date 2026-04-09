<?php

declare(strict_types=1);

namespace App\Application\Notifications\Sms;

interface SmsProviderInterface
{
    public function send(string $to, string $message): void;
}
