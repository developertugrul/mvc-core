<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;

final class HomeController
{
    public function index(Request $request): Response
    {
        return View::render('home', [
            'isAuthenticated' => Auth::check(),
            'csrfToken' => Csrf::token(),
        ]);
    }
}
