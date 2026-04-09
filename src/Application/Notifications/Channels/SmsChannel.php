<?php

declare(strict_types=1);

namespace App\Application\Notifications\Channels;

use App\Application\Notifications\VerifyEmailNotification;

final class SmsChannel
{
    public function send(VerifyEmailNotification $notification): void
    {
        $_SESSION['sms_notifications'][] = [
            'to' => $notification->email,
            'message' => 'Verify your account token: ' . $notification->token,
        ];
    }
}
