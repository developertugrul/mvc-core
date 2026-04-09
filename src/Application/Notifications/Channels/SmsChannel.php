<?php

declare(strict_types=1);

namespace App\Application\Notifications\Channels;

use App\Application\Notifications\VerifyEmailNotification;
use App\Application\Notifications\Sms\SmsManager;

final class SmsChannel
{
    public function __construct(private SmsManager $smsManager)
    {
    }

    public function send(VerifyEmailNotification $notification): void
    {
        $to = (string) ($notification->phone ?? '');
        if ($to === '') {
            return;
        }
        $message = 'Verify your account token: ' . $notification->token;
        $this->smsManager->provider()->send($to, $message);
    }
}
