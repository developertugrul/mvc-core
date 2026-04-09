<?php

declare(strict_types=1);

namespace App\Application\Repositories;

use PDO;

final class UserRepository
{
    public function __construct(private PDO $db)
    {
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT id, name, email, password_hash, role FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function create(string $name, string $email, string $passwordHash, string $role = 'user'): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO users (name, email, password_hash, role, created_at) VALUES (:name, :email, :password_hash, :role, NOW())'
        );
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash,
            'role' => $role,
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function storeEmailVerificationToken(int $userId, string $tokenHash, string $expiresAt): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO email_verification_tokens (user_id, token_hash, expires_at, created_at) VALUES (:user_id, :token_hash, :expires_at, NOW())'
        );
        $stmt->execute([
            'user_id' => $userId,
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt,
        ]);
    }

    public function consumeEmailVerificationToken(string $tokenHash): ?int
    {
        $stmt = $this->db->prepare(
            'SELECT id, user_id FROM email_verification_tokens WHERE token_hash = :token_hash AND used_at IS NULL AND expires_at >= NOW() ORDER BY id DESC LIMIT 1'
        );
        $stmt->execute(['token_hash' => $tokenHash]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }

        $update = $this->db->prepare('UPDATE email_verification_tokens SET used_at = NOW() WHERE id = :id');
        $update->execute(['id' => $row['id']]);
        return (int) $row['user_id'];
    }

    public function storePasswordResetToken(int $userId, string $tokenHash, string $expiresAt): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO password_reset_tokens (user_id, token_hash, expires_at, created_at) VALUES (:user_id, :token_hash, :expires_at, NOW())'
        );
        $stmt->execute([
            'user_id' => $userId,
            'token_hash' => $tokenHash,
            'expires_at' => $expiresAt,
        ]);
    }

    public function consumePasswordResetToken(string $tokenHash): ?int
    {
        $stmt = $this->db->prepare(
            'SELECT id, user_id FROM password_reset_tokens WHERE token_hash = :token_hash AND used_at IS NULL AND expires_at >= NOW() ORDER BY id DESC LIMIT 1'
        );
        $stmt->execute(['token_hash' => $tokenHash]);
        $row = $stmt->fetch();
        if (!$row) {
            return null;
        }

        $update = $this->db->prepare('UPDATE password_reset_tokens SET used_at = NOW() WHERE id = :id');
        $update->execute(['id' => $row['id']]);
        return (int) $row['user_id'];
    }

    public function updatePasswordByUserId(int $userId, string $passwordHash): void
    {
        $stmt = $this->db->prepare('UPDATE users SET password_hash = :password_hash WHERE id = :id');
        $stmt->execute([
            'password_hash' => $passwordHash,
            'id' => $userId,
        ]);
    }
}
