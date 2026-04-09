<?php

declare(strict_types=1);

namespace App\Application\Notifications\Sms;

use App\Core\Config;
use Twilio\Rest\Client;

final class TwilioSmsProvider implements SmsProviderInterface
{
    public function __construct(private Config $config)
    {
    }

    public function send(string $to, string $message): void
    {
        $sid = $this->config->string('twilio_sid');
        $token = $this->config->string('twilio_token');
        $from = $this->config->string('twilio_from', $this->config->string('sms_from'));
        if ($sid === '' || $token === '' || $from === '') {
            return;
        }

        $client = new Client($sid, $token);
        $client->messages->create($to, [
            'from' => $from,
            'body' => $message,
        ]);
    }
}
