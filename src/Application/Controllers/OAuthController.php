<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Services\OAuthService;
use App\Core\Request;
use App\Core\Response;

final class OAuthController
{
    public function __construct(private OAuthService $oauth)
    {
    }

    public function token(Request $request): Response
    {
        $grantType = (string) $request->input('grant_type', '');
        $result = $this->oauth->issueToken($grantType, $request->body + $request->query);
        if (isset($result['error'])) {
            return Response::json($result, 400);
        }

        return Response::json($result, 200);
    }

    public function me(Request $request): Response
    {
        return Response::json([
            'client_id' => $request->attribute('oauth_client_id'),
            'user_id' => $request->attribute('oauth_user_id'),
            'scope' => $request->attribute('oauth_scope'),
        ]);
    }
}
