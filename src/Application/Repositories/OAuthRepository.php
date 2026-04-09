<?php

declare(strict_types=1);

namespace App\Application\Repositories;

use PDO;

final class OAuthRepository
{
    public function __construct(private PDO $db)
    {
    }

    public function findActiveClient(string $clientId): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM oauth_clients WHERE client_id = :client_id AND is_active = 1 LIMIT 1');
        $stmt->execute(['client_id' => $clientId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function createAccessToken(string $tokenHash, string $clientId, ?int $userId, string $scope, string $expiresAt): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO oauth_access_tokens (token_hash, client_id, user_id, scope, expires_at, created_at) VALUES (:token_hash, :client_id, :user_id, :scope, :expires_at, NOW())'
        );
        $stmt->execute([
            'token_hash' => $tokenHash,
            'client_id' => $clientId,
            'user_id' => $userId,
            'scope' => $scope,
            'expires_at' => $expiresAt,
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function createRefreshToken(string $tokenHash, int $accessTokenId, string $expiresAt): void
    {
        $stmt = $this->db->prepare(
            'INSERT INTO oauth_refresh_tokens (token_hash, access_token_id, expires_at, created_at) VALUES (:token_hash, :access_token_id, :expires_at, NOW())'
        );
        $stmt->execute([
            'token_hash' => $tokenHash,
            'access_token_id' => $accessTokenId,
            'expires_at' => $expiresAt,
        ]);
    }

    public function findValidAccessToken(string $tokenHash): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM oauth_access_tokens WHERE token_hash = :token_hash AND revoked_at IS NULL AND expires_at >= NOW() LIMIT 1'
        );
        $stmt->execute(['token_hash' => $tokenHash]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function revokeAccessToken(int $accessTokenId): void
    {
        $stmt = $this->db->prepare('UPDATE oauth_access_tokens SET revoked_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $accessTokenId]);
    }

    public function findRefreshToken(string $tokenHash): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT rt.*, at.client_id, at.user_id, at.scope
             FROM oauth_refresh_tokens rt
             INNER JOIN oauth_access_tokens at ON at.id = rt.access_token_id
             WHERE rt.token_hash = :token_hash
               AND rt.revoked_at IS NULL
               AND rt.expires_at >= NOW()
               AND at.revoked_at IS NULL
             LIMIT 1'
        );
        $stmt->execute(['token_hash' => $tokenHash]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function revokeRefreshToken(int $refreshTokenId): void
    {
        $stmt = $this->db->prepare('UPDATE oauth_refresh_tokens SET revoked_at = NOW() WHERE id = :id');
        $stmt->execute(['id' => $refreshTokenId]);
    }
}
