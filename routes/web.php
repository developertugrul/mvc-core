<?php

declare(strict_types=1);

use App\Application\Controllers\AuthController;
use App\Application\Controllers\DashboardController;
use App\Application\Controllers\HomeController;
use App\Application\Controllers\LanguageController;
use App\Application\Controllers\FileController;
use App\Application\Controllers\ComponentController;
use App\Application\Controllers\LegalController;
use App\Application\Middleware\AuthMiddleware;
use App\Application\Middleware\AdminMiddleware;
use App\Application\Middleware\CsrfMiddleware;
use App\Application\Middleware\GuestMiddleware;
use App\Application\Middleware\LocaleMiddleware;
use App\Application\Middleware\PermissionMiddleware;
use App\Application\Middleware\RateLimitMiddleware;
use App\Application\Middleware\SecurityHeadersMiddleware;
use App\Application\Middleware\TrimInputMiddleware;

 $baseRoutes = [
    ['method' => 'GET', 'uri' => '/', 'handler' => [HomeController::class, 'index']],
    ['method' => 'GET', 'uri' => '/login', 'handler' => [AuthController::class, 'showLogin'], 'middleware' => [GuestMiddleware::class]],
    ['method' => 'POST', 'uri' => '/login', 'handler' => [AuthController::class, 'login'], 'middleware' => [TrimInputMiddleware::class, CsrfMiddleware::class, GuestMiddleware::class]],
    ['method' => 'GET', 'uri' => '/register', 'handler' => [AuthController::class, 'showRegister'], 'middleware' => [GuestMiddleware::class]],
    ['method' => 'POST', 'uri' => '/register', 'handler' => [AuthController::class, 'register'], 'middleware' => [TrimInputMiddleware::class, CsrfMiddleware::class, GuestMiddleware::class]],
    ['method' => 'GET', 'uri' => '/forgot-password', 'handler' => [AuthController::class, 'showForgotPassword'], 'middleware' => [GuestMiddleware::class]],
    ['method' => 'POST', 'uri' => '/forgot-password', 'handler' => [AuthController::class, 'sendResetLink'], 'middleware' => [TrimInputMiddleware::class, CsrfMiddleware::class, GuestMiddleware::class]],
    ['method' => 'GET', 'uri' => '/confirm-password', 'handler' => [AuthController::class, 'showConfirmPassword'], 'middleware' => [AuthMiddleware::class]],
    ['method' => 'POST', 'uri' => '/confirm-password', 'handler' => [AuthController::class, 'confirmPassword'], 'middleware' => [TrimInputMiddleware::class, CsrfMiddleware::class, AuthMiddleware::class]],
    ['method' => 'GET', 'uri' => '/reset-password', 'handler' => [AuthController::class, 'showResetPassword'], 'middleware' => [GuestMiddleware::class]],
    ['method' => 'POST', 'uri' => '/reset-password', 'handler' => [AuthController::class, 'resetPassword'], 'middleware' => [TrimInputMiddleware::class, CsrfMiddleware::class, GuestMiddleware::class]],
    ['method' => 'GET', 'uri' => '/profile', 'handler' => [AuthController::class, 'profile'], 'middleware' => [AuthMiddleware::class]],
    ['method' => 'GET', 'uri' => '/verify-email', 'handler' => [AuthController::class, 'verifyEmail']],
    ['method' => 'POST', 'uri' => '/logout', 'handler' => [AuthController::class, 'logout'], 'middleware' => [CsrfMiddleware::class, AuthMiddleware::class]],
    ['method' => 'GET', 'uri' => '/dashboard', 'handler' => [DashboardController::class, 'index'], 'middleware' => [AuthMiddleware::class]],
    ['method' => 'GET', 'uri' => '/admin/dashboard', 'handler' => [DashboardController::class, 'index'], 'middleware' => [AuthMiddleware::class, AdminMiddleware::class]],
    ['method' => 'GET', 'uri' => '/admin/reports', 'handler' => [DashboardController::class, 'index'], 'middleware' => [AuthMiddleware::class, PermissionMiddleware::class], 'permission' => 'reports.view'],
    ['method' => 'GET', 'uri' => '/settings/language', 'handler' => [LanguageController::class, 'settings'], 'middleware' => [CsrfMiddleware::class, AuthMiddleware::class]],
    ['method' => 'POST', 'uri' => '/settings/language', 'handler' => [LanguageController::class, 'update'], 'middleware' => [CsrfMiddleware::class, AuthMiddleware::class]],
    ['method' => 'GET', 'uri' => '/cookie-policy', 'handler' => [LegalController::class, 'cookiePolicy']],
    ['method' => 'GET', 'uri' => '/terms-of-use', 'handler' => [LegalController::class, 'termsOfUse']],
    ['method' => 'GET', 'uri' => '/privacy-policy', 'handler' => [LegalController::class, 'privacyPolicy']],
    ['method' => 'GET', 'uri' => '/export/pdf', 'handler' => [FileController::class, 'exportPdf'], 'middleware' => [AuthMiddleware::class]],
    ['method' => 'GET', 'uri' => '/export/xlsx', 'handler' => [FileController::class, 'exportXlsx'], 'middleware' => [AuthMiddleware::class]],
    ['method' => 'GET', 'uri' => '/export/csv', 'handler' => [FileController::class, 'exportCsv'], 'middleware' => [AuthMiddleware::class]],
    ['method' => 'POST', 'uri' => '/import/csv', 'handler' => [FileController::class, 'importCsv'], 'middleware' => [CsrfMiddleware::class, AuthMiddleware::class]],
    ['method' => 'POST', 'uri' => '/_components/{name}/{action}', 'handler' => [ComponentController::class, 'action'], 'middleware' => [CsrfMiddleware::class]],
];

$localizedRoutes = [];
foreach ($baseRoutes as $route) {
    $route['middleware'] = array_values(array_unique([SecurityHeadersMiddleware::class, RateLimitMiddleware::class, LocaleMiddleware::class, ...($route['middleware'] ?? [])]));
    $localizedRoutes[] = $route;

    if ($route['uri'] === '/') {
        $localizedRoutes[] = ['method' => $route['method'], 'uri' => '/{locale:(tr|en)}', 'handler' => $route['handler'], 'middleware' => $route['middleware']];
    } else {
        $localizedRoutes[] = ['method' => $route['method'], 'uri' => '/{locale:(tr|en)}' . $route['uri'], 'handler' => $route['handler'], 'middleware' => $route['middleware']];
    }
}

return $localizedRoutes;
