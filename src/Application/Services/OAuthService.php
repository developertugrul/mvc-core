<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Repositories\OAuthRepository;
use App\Application\Repositories\UserRepository;
use App\Core\Config;

final class OAuthService
{
    public function __construct(
        private OAuthRepository $oauth,
        private UserRepository $users,
        private Config $config
    ) {
    }

    public function issueToken(string $grantType, array $input): array
    {
        return match ($grantType) {
            'client_credentials' => $this->issueClientCredentials($input),
            'password' => $this->issuePassword($input),
            'refresh_token' => $this->issueRefreshToken($input),
            default => ['error' => 'unsupported_grant_type'],
        };
    }

    public function validateBearer(string $token): ?array
    {
        return $this->oauth->findValidAccessToken(hash('sha256', $token));
    }

    private function issueClientCredentials(array $input): array
    {
        $client = $this->validateClient($input);
        if ($client === null) {
            return ['error' => 'invalid_client'];
        }
        if (!$this->clientAllowsGrant($client, 'client_credentials')) {
            return ['error' => 'unauthorized_client'];
        }

        return $this->createTokenPair((string) $client['client_id'], null, (string) ($input['scope'] ?? ''));
    }

    private function issuePassword(array $input): array
    {
        $client = $this->validateClient($input);
        if ($client === null) {
            return ['error' => 'invalid_client'];
        }
        if (!$this->clientAllowsGrant($client, 'password')) {
            return ['error' => 'unauthorized_client'];
        }

        $email = (string) ($input['username'] ?? '');
        $password = (string) ($input['password'] ?? '');
        $user = $this->users->findByEmail($email);
        if ($user === null || !password_verify($password, (string) $user['password_hash'])) {
            return ['error' => 'invalid_grant'];
        }

        return $this->createTokenPair((string) $client['client_id'], (int) $user['id'], (string) ($input['scope'] ?? ''));
    }

    private function issueRefreshToken(array $input): array
    {
        $client = $this->validateClient($input);
        if ($client === null) {
            return ['error' => 'invalid_client'];
        }
        if (!$this->clientAllowsGrant($client, 'refresh_token')) {
            return ['error' => 'unauthorized_client'];
        }

        $refresh = (string) ($input['refresh_token'] ?? '');
        if ($refresh === '') {
            return ['error' => 'invalid_request'];
        }

        $tokenRow = $this->oauth->findRefreshToken(hash('sha256', $refresh));
        if ($tokenRow === null || (string) $tokenRow['client_id'] !== (string) $client['client_id']) {
            return ['error' => 'invalid_grant'];
        }

        $this->oauth->revokeRefreshToken((int) $tokenRow['id']);
        $this->oauth->revokeAccessToken((int) $tokenRow['access_token_id']);

        return $this->createTokenPair((string) $client['client_id'], isset($tokenRow['user_id']) ? (int) $tokenRow['user_id'] : null, (string) ($tokenRow['scope'] ?? ''));
    }

    private function validateClient(array $input): ?array
    {
        $clientId = (string) ($input['client_id'] ?? '');
        $clientSecret = (string) ($input['client_secret'] ?? '');
        if ($clientId === '' || $clientSecret === '') {
            return null;
        }

        $client = $this->oauth->findActiveClient($clientId);
        if ($client === null) {
            return null;
        }

        if (!hash_equals((string) $client['client_secret_hash'], hash('sha256', $clientSecret))) {
            return null;
        }

        return $client;
    }

    private function createTokenPair(string $clientId, ?int $userId, string $scope): array
    {
        $accessToken = bin2hex(random_bytes(32));
        $refreshToken = bin2hex(random_bytes(32));
        $accessTtl = max(60, $this->config->int('oauth_access_token_ttl', 3600));
        $refreshTtl = max(300, $this->config->int('oauth_refresh_token_ttl', 2592000));
        $accessExpires = date('Y-m-d H:i:s', time() + $accessTtl);
        $refreshExpires = date('Y-m-d H:i:s', time() + $refreshTtl);

        $accessId = $this->oauth->createAccessToken(
            hash('sha256', $accessToken),
            $clientId,
            $userId,
            $scope,
            $accessExpires
        );

        $this->oauth->createRefreshToken(hash('sha256', $refreshToken), $accessId, $refreshExpires);

        return [
            'token_type' => 'Bearer',
            'access_token' => $accessToken,
            'expires_in' => $accessTtl,
            'refresh_token' => $refreshToken,
            'scope' => $scope,
        ];
    }

    private function clientAllowsGrant(array $client, string $grant): bool
    {
        $grants = array_map('trim', explode(',', (string) ($client['grants'] ?? '')));
        return in_array($grant, $grants, true);
    }
}
