<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Services\OAuthClientService;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;

final class OAuthClientController
{
    public function __construct(private OAuthClientService $clients)
    {
    }

    public function index(Request $request): Response
    {
        $generated = $_SESSION['_oauth_generated'] ?? null;
        unset($_SESSION['_oauth_generated']);

        return View::render('admin/oauth-clients', [
            'csrfToken' => Csrf::token(),
            'clients' => $this->clients->list(),
            'generated' => $generated,
        ]);
    }

    public function create(Request $request): Response
    {
        $name = trim((string) $request->input('name', 'OAuth Client'));
        $grants = $request->body['grants'] ?? [];
        if (!is_array($grants)) {
            $grants = [];
        }

        $generated = $this->clients->create($name, $grants);
        $_SESSION['_oauth_generated'] = $generated;
        return Response::redirect('/admin/oauth-clients');
    }

    public function revoke(Request $request, string $clientId): Response
    {
        $this->clients->revoke($clientId);
        return Response::redirect('/admin/oauth-clients');
    }

    public function rotate(Request $request, string $clientId): Response
    {
        $secret = $this->clients->rotateSecret($clientId);
        $_SESSION['_oauth_generated'] = [
            'client_id' => $clientId,
            'client_secret' => $secret['client_secret'],
        ];
        return Response::redirect('/admin/oauth-clients');
    }
}
