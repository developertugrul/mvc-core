<?php

declare(strict_types=1);

namespace App\Application\Notifications;

use App\Application\Notifications\Channels\InAppChannel;
use App\Application\Notifications\Channels\MailChannel;
use App\Application\Notifications\Channels\SmsChannel;
use App\Application\Notifications\Channels\WebPushChannel;

final class Notifier
{
    public function __construct(
        private MailChannel $mailChannel,
        private SmsChannel $smsChannel,
        private WebPushChannel $webPushChannel,
        private InAppChannel $inAppChannel
    ) {
    }

    public function send(Notification $notification): void
    {
        if ($notification instanceof VerifyEmailNotification) {
            foreach ($notification->channels() as $channel) {
                try {
                    match ($channel) {
                        'mail' => $this->mailChannel->send($notification),
                        'sms' => $this->smsChannel->send($notification),
                        'web_push' => $this->webPushChannel->send($notification),
                        'in_app' => $this->inAppChannel->send($notification),
                        default => null,
                    };
                } catch (\Throwable $e) {
                    error_log('[notification][' . $channel . '] ' . $e->getMessage());
                }
            }
        }
    }
}
