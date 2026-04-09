<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Services\AuthService;
use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;

final class AuthController
{
    public function __construct(private AuthService $authService)
    {
    }

    public function showLogin(Request $request): Response
    {
        return View::render('auth/login', ['csrfToken' => Csrf::token()]);
    }

    public function login(Request $request): Response
    {
        $ok = $this->authService->attempt((string) $request->input('email'), (string) $request->input('password'));
        return $ok ? Response::redirect('/dashboard') : new Response('Login failed', 401);
    }

    public function showRegister(Request $request): Response
    {
        return View::render('auth/register', ['csrfToken' => Csrf::token()]);
    }

    public function register(Request $request): Response
    {
        $this->authService->register(
            (string) $request->input('name'),
            (string) $request->input('email'),
            (string) $request->input('password')
        );

        return Response::redirect('/login');
    }

    public function logout(Request $request): Response
    {
        Auth::logout();
        return Response::redirect('/');
    }
}
