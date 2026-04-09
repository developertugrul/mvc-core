<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Core\Component\ComponentRegistry;
use App\Core\Component\ComponentSigner;
use App\Core\Request;
use App\Core\Response;

final class ComponentController
{
    public function __construct(
        private ComponentRegistry $registry,
        private ComponentSigner $signer
    ) {
    }

    public function action(Request $request, string $name, string $action): Response
    {
        $encoded = (string) $request->input('payload', '');
        $signature = (string) $request->input('signature', '');
        $decoded = base64_decode($encoded, true);
        if ($decoded === false || !$this->signer->verify($decoded, $signature)) {
            return Response::json(['message' => 'Invalid component signature'], 422);
        }

        $payload = json_decode($decoded, true);
        if (!is_array($payload)) {
            return Response::json(['message' => 'Invalid payload'], 422);
        }

        $component = $this->registry->make($name);
        if ($component === null) {
            return Response::json(['message' => 'Component not found'], 404);
        }

        $component->hydrate((array) ($payload['state'] ?? []));
        $component->call($action, (array) $request->input('data', []));

        $newPayload = json_encode(['name' => $name, 'state' => $component->state()], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '{}';
        return Response::json([
            'html' => $component->render(),
            'payload' => base64_encode($newPayload),
            'signature' => $this->signer->sign($newPayload),
        ]);
    }
}
