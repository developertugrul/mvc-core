# Routing and Middleware

## Route format

All routes are defined in `routes/web.php` as arrays:

```php
[
  'method' => 'GET',
  'uri' => '/dashboard',
  'handler' => [DashboardController::class, 'index'],
  'middleware' => [AuthMiddleware::class]
]
```

## Optional locale prefix

The app generates both:

- `/dashboard`
- `/{locale}/dashboard` where locale is `tr|en`

This is done automatically when route table is expanded.

## Middleware chain

Execution order is left-to-right.

Global-ish middleware appended on each route:

- `SecurityHeadersMiddleware`
- `RateLimitMiddleware`
- `LocaleMiddleware`

Route-specific middleware examples:

- `AuthMiddleware`
- `GuestMiddleware`
- `CsrfMiddleware`
- `TrimInputMiddleware`

## Component endpoint

Livewire-like action endpoint:

```http
POST /_components/{name}/{action}
```

Protected by CSRF and signature verification.
