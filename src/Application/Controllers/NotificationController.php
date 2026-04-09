<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Notifications\WebPush\WebPushService;
use App\Core\Request;
use App\Core\Response;

final class NotificationController
{
    public function __construct(private WebPushService $webPushService)
    {
    }

    public function subscribeWebPush(Request $request): Response
    {
        $raw = file_get_contents('php://input');
        $payload = json_decode((string) $raw, true);
        if (!is_array($payload) || !isset($payload['endpoint'], $payload['keys'])) {
            return Response::json(['message' => 'Invalid subscription payload'], 422);
        }

        $this->webPushService->storeSubscription($payload);
        return Response::json(['message' => 'Subscribed']);
    }
}
