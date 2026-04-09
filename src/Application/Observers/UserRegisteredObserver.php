<?php

declare(strict_types=1);

namespace App\Application\Observers;

use App\Application\Notifications\VerifyEmailNotification;
use App\Application\Notifications\Notifier;

final class UserRegisteredObserver
{
    public function __construct(private Notifier $notifier)
    {
    }

    /** @param array<string, mixed> $payload */
    public function __invoke(array $payload): void
    {
        $email = (string) ($payload['email'] ?? '');
        $name = (string) ($payload['name'] ?? 'User');
        if ($email === '') {
            return;
        }

        $token = bin2hex(random_bytes(16));
        $this->notifier->send(new VerifyEmailNotification($name, $email, $token));
    }
}
