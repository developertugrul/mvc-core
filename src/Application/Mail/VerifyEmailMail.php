<?php

declare(strict_types=1);

namespace App\Application\Mail;

final class VerifyEmailMail extends Mailable
{
    public function __construct(
        private string $name,
        private string $verifyUrl
    ) {
    }

    public function subject(): string
    {
        return 'Please verify your email';
    }

    public function html(): string
    {
        return '<html><body style="font-family:Arial,sans-serif"><h2>Email Verification</h2><p>Hello ' .
            htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8') .
            ', please verify your email address by clicking the button below.</p><p><a style="display:inline-block;padding:10px 14px;background:#0f172a;color:#fff;text-decoration:none;border-radius:6px" href="' .
            htmlspecialchars($this->verifyUrl, ENT_QUOTES, 'UTF-8') .
            '">Verify Email</a></p></body></html>';
    }
}
