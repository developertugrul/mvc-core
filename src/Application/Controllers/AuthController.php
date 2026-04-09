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

    public function showForgotPassword(Request $request): Response
    {
        return View::render('auth/forgot-password', ['csrfToken' => Csrf::token()]);
    }

    public function sendResetLink(Request $request): Response
    {
        return new Response('Reset link sent (demo).', 200);
    }

    public function showConfirmPassword(Request $request): Response
    {
        return View::render('auth/confirm-password', ['csrfToken' => Csrf::token()]);
    }

    public function confirmPassword(Request $request): Response
    {
        return new Response('Password confirmed (demo).', 200);
    }

    public function showResetPassword(Request $request): Response
    {
        return View::render('auth/reset-password', ['csrfToken' => Csrf::token(), 'token' => (string) $request->input('token', '')]);
    }

    public function resetPassword(Request $request): Response
    {
        return new Response('Password reset completed (demo).', 200);
    }

    public function profile(Request $request): Response
    {
        return View::render('auth/profile', ['userId' => Auth::id(), 'role' => Auth::role()]);
    }

    public function verifyEmail(Request $request): Response
    {
        $token = (string) $request->input('token', '');
        if ($token === '') {
            return new Response('Invalid verification token', 422);
        }
        return new Response('Email verified (demo).', 200);
    }
}
