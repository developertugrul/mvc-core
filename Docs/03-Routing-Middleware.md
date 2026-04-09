# Routing and Middleware

Routes are declared in `routes/web.php`.

Each route item contains:

- `method`
- `uri`
- `handler` (`[Controller::class, 'method']`)
- optional `middleware` array

Example:

```php
['method' => 'GET', 'uri' => '/dashboard', 'handler' => [DashboardController::class, 'index'], 'middleware' => [AuthMiddleware::class]]
```

Middleware execution order is left-to-right in route declaration.

Available middleware examples:

- `TrimInputMiddleware`
- `CsrfMiddleware`
- `GuestMiddleware`
- `AuthMiddleware`
