<?php

declare(strict_types=1);

namespace App\Application\Notifications\Channels;

use App\Application\Notifications\VerifyEmailNotification;
use App\Application\Notifications\WebPush\WebPushService;

final class WebPushChannel
{
    public function __construct(private WebPushService $webPushService)
    {
    }

    public function send(VerifyEmailNotification $notification): void
    {
        // Never broadcast sensitive verification tokens over shared push subscriptions.
        $this->webPushService->sendToAll('Verify your email', 'Please check your inbox to verify your account.');
    }
}
