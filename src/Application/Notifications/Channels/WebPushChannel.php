<?php

declare(strict_types=1);

namespace App\Application\Notifications\Channels;

use App\Application\Notifications\VerifyEmailNotification;

final class WebPushChannel
{
    public function send(VerifyEmailNotification $notification): void
    {
        $_SESSION['web_push_notifications'][] = [
            'title' => 'Verify your email',
            'body' => 'Token: ' . $notification->token,
        ];
    }
}
