<?php

declare(strict_types=1);

namespace App\Application\Notifications\Sms;

use GuzzleHttp\Client;

final class HttpSmsProvider implements SmsProviderInterface
{
    public function __construct(
        private string $endpoint,
        private string $token,
        private string $sender
    ) {
    }

    public function send(string $to, string $message): void
    {
        if ($this->endpoint === '' || $this->token === '') {
            return;
        }

        $client = new Client(['timeout' => 10]);
        $client->post($this->endpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
            ],
            'json' => [
                'to' => $to,
                'from' => $this->sender,
                'message' => $message,
            ],
        ]);
    }
}
