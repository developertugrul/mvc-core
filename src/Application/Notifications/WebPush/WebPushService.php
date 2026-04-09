<?php

declare(strict_types=1);

namespace App\Application\Notifications\WebPush;

use App\Core\Config;
use Minishlink\WebPush\Subscription;
use Minishlink\WebPush\WebPush;

final class WebPushService
{
    public function __construct(private Config $config)
    {
    }

    public function storeSubscription(array $subscription): void
    {
        $path = $this->config->storagePath('private/webpush_subscriptions.json');
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0775, true);
        }

        $items = [];
        if (file_exists($path)) {
            $items = json_decode((string) file_get_contents($path), true);
            if (!is_array($items)) {
                $items = [];
            }
        }

        $items[] = $subscription;
        file_put_contents($path, json_encode($items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }

    public function sendToAll(string $title, string $body): void
    {
        $path = $this->config->storagePath('private/webpush_subscriptions.json');
        if (!file_exists($path)) {
            return;
        }

        $items = json_decode((string) file_get_contents($path), true);
        if (!is_array($items) || $items === []) {
            return;
        }

        $publicKey = $this->config->string('webpush_public_key');
        $privateKey = $this->config->string('webpush_private_key');
        if ($publicKey === '' || $privateKey === '') {
            return;
        }

        $webPush = new WebPush([
            'VAPID' => [
                'subject' => $this->config->string('webpush_subject'),
                'publicKey' => $publicKey,
                'privateKey' => $privateKey,
            ],
        ]);

        $payload = json_encode(['title' => $title, 'body' => $body], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';
        foreach ($items as $subscription) {
            if (!is_array($subscription)) {
                continue;
            }
            $webPush->queueNotification(Subscription::create($subscription), $payload);
        }
        $webPush->flush();
    }
}
