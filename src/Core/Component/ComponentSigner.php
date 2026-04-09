<?php

declare(strict_types=1);

namespace App\Core\Component;

final class ComponentSigner
{
    public function __construct(private string $key)
    {
    }

    public function sign(string $payload): string
    {
        return hash_hmac('sha256', $payload, $this->key);
    }

    public function verify(string $payload, string $signature): bool
    {
        return hash_equals($this->sign($payload), $signature);
    }
}
