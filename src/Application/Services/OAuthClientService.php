<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Repositories\OAuthRepository;

final class OAuthClientService
{
    public function __construct(private OAuthRepository $oauth)
    {
    }

    /** @return array<int, array<string, mixed>> */
    public function list(): array
    {
        return $this->oauth->listClients();
    }

    /** @return array{client_id: string, client_secret: string} */
    public function create(string $name, array $grants): array
    {
        $clientId = 'cli_' . bin2hex(random_bytes(8));
        $clientSecret = bin2hex(random_bytes(24));
        $normalizedGrants = $this->normalizeGrants($grants);

        $this->oauth->createClient($clientId, hash('sha256', $clientSecret), $name, implode(',', $normalizedGrants));

        return [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
        ];
    }

    /** @return array{client_secret: string} */
    public function rotateSecret(string $clientId): array
    {
        $secret = bin2hex(random_bytes(24));
        $this->oauth->rotateClientSecret($clientId, hash('sha256', $secret));
        return ['client_secret' => $secret];
    }

    public function revoke(string $clientId): void
    {
        $this->oauth->deactivateClient($clientId);
    }

    /** @return array<int, string> */
    private function normalizeGrants(array $grants): array
    {
        $allowed = ['client_credentials', 'password', 'refresh_token'];
        $picked = array_values(array_intersect($allowed, array_map('strval', $grants)));
        return $picked !== [] ? $picked : ['client_credentials'];
    }
}
