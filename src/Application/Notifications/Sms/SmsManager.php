<?php

declare(strict_types=1);

namespace App\Application\Notifications\Sms;

use App\Core\Config;

final class SmsManager
{
    public function __construct(private Config $config)
    {
    }

    public function provider(): SmsProviderInterface
    {
        $provider = strtolower($this->config->string('sms_provider', 'twilio'));
        $sender = $this->config->string('sms_from');

        return match ($provider) {
            'vodafone' => new VodafoneSmsProvider(
                $this->config->string('vodafone_sms_endpoint'),
                $this->config->string('vodafone_sms_token'),
                $sender
            ),
            'turkcell' => new TurkcellSmsProvider(
                $this->config->string('turkcell_sms_endpoint'),
                $this->config->string('turkcell_sms_token'),
                $sender
            ),
            'turktelekom' => new TurkTelekomSmsProvider(
                $this->config->string('turktelekom_sms_endpoint'),
                $this->config->string('turktelekom_sms_token'),
                $sender
            ),
            default => new TwilioSmsProvider($this->config),
        };
    }
}
