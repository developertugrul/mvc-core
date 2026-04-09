<?php

declare(strict_types=1);

namespace App\Application\Notifications\Channels;

use App\Application\Mail\Mailer;
use App\Application\Mail\VerifyEmailMail;
use App\Application\Notifications\VerifyEmailNotification;
use App\Core\Config;

final class MailChannel
{
    public function __construct(private Mailer $mailer, private Config $config)
    {
    }

    public function send(VerifyEmailNotification $notification): void
    {
        $url = rtrim($this->config->string('app_url', ''), '/') . '/verify-email?token=' . urlencode($notification->token);
        $this->mailer->send($notification->email, new VerifyEmailMail($notification->name, $url));
    }
}
