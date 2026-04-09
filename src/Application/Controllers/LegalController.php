<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Core\View;

final class LegalController
{
    public function cookiePolicy(Request $request): Response
    {
        return View::render('legal/cookie-policy');
    }

    public function termsOfUse(Request $request): Response
    {
        return View::render('legal/terms-of-use');
    }

    public function privacyPolicy(Request $request): Response
    {
        return View::render('legal/privacy-policy');
    }
}
