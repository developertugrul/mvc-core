<?php

declare(strict_types=1);

namespace App\Application\Notifications\Channels;

use App\Application\Notifications\VerifyEmailNotification;

final class InAppChannel
{
    public function send(VerifyEmailNotification $notification): void
    {
        $_SESSION['in_app_notifications'][] = [
            'type' => 'verify_email',
            'user' => $notification->email,
            'token' => $notification->token,
        ];
    }
}
