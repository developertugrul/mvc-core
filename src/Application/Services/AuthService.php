<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Mail\Mailer;
use App\Application\Mail\ResetPasswordMail;
use App\Application\Mail\VerifyEmailMail;
use App\Application\Repositories\UserRepository;
use App\Core\Auth;
use App\Core\Config;
use App\Core\Events\EventDispatcher;

final class AuthService
{
    public function __construct(
        private UserRepository $users,
        private EventDispatcher $events,
        private Mailer $mailer,
        private Config $config
    )
    {
    }

    public function register(string $name, string $email, string $password): int
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $id = $this->users->create($name, $email, $hash);
        $token = bin2hex(random_bytes(32));
        $this->users->storeEmailVerificationToken(
            $id,
            hash('sha256', $token),
            date('Y-m-d H:i:s', time() + 86400)
        );
        $this->events->dispatch('user.registered', ['id' => $id, 'name' => $name, 'email' => $email, 'token' => $token]);
        return $id;
    }

    public function attempt(string $email, string $password): bool
    {
        return Auth::attempt($this->users, $email, $password);
    }

    public function sendPasswordReset(string $email): void
    {
        $user = $this->users->findByEmail($email);
        if ($user === null) {
            return;
        }

        $token = bin2hex(random_bytes(32));
        $this->users->storePasswordResetToken(
            (int) $user['id'],
            hash('sha256', $token),
            date('Y-m-d H:i:s', time() + 3600)
        );

        $url = rtrim($this->config->string('app_url', ''), '/') . '/reset-password?token=' . urlencode($token);
        $this->mailer->send((string) $user['email'], new ResetPasswordMail((string) $user['name'], $url));
    }

    public function resetPassword(string $token, string $password): bool
    {
        $userId = $this->users->consumePasswordResetToken(hash('sha256', $token));
        if ($userId === null) {
            return false;
        }

        $this->users->updatePasswordByUserId($userId, password_hash($password, PASSWORD_DEFAULT));
        return true;
    }

    public function verifyEmail(string $token): bool
    {
        return $this->users->consumeEmailVerificationToken(hash('sha256', $token)) !== null;
    }
}
