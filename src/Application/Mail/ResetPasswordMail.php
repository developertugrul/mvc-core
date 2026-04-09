<?php

declare(strict_types=1);

namespace App\Application\Mail;

final class ResetPasswordMail extends Mailable
{
    public function __construct(
        private string $name,
        private string $resetUrl
    ) {
    }

    public function subject(): string
    {
        return 'Reset your password';
    }

    public function html(): string
    {
        return '<html><body style="font-family:Arial,sans-serif"><h2>Password Reset</h2><p>Hello ' .
            htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8') .
            ', click the button below to reset your password.</p><p><a style="display:inline-block;padding:10px 14px;background:#0f172a;color:#fff;text-decoration:none;border-radius:6px" href="' .
            htmlspecialchars($this->resetUrl, ENT_QUOTES, 'UTF-8') .
            '">Reset Password</a></p></body></html>';
    }
}
