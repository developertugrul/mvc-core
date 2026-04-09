<?php

declare(strict_types=1);

namespace App\Application\Mail;

use App\Core\Config;
use Symfony\Component\Mailer\Mailer as SymfonyMailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

final class Mailer
{
    private SymfonyMailer $mailer;
    private string $fromAddress;

    public function __construct(Config $config)
    {
        $dsn = $config->string('mail_dsn', 'smtp://localhost');
        $this->fromAddress = $config->string('mail_from', 'no-reply@example.com');
        $this->mailer = new SymfonyMailer(Transport::fromDsn($dsn));
    }

    public function send(string $to, Mailable $mailable): void
    {
        $email = (new Email())
            ->from($this->fromAddress)
            ->to($to)
            ->subject($mailable->subject())
            ->html($mailable->html());

        $this->mailer->send($email);
    }
}
