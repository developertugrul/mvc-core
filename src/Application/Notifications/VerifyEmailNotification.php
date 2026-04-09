<?php

declare(strict_types=1);

namespace App\Application\Notifications;

final class VerifyEmailNotification extends Notification
{
    public function __construct(
        public string $name,
        public string $email,
        public string $token,
        public ?string $phone = null
    ) {
    }

    public function channels(): array
    {
        return ['mail', 'in_app', 'sms', 'web_push'];
    }
}
