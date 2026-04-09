# Examples

## Add a new protected route

In `routes/web.php`:

```php
['method' => 'GET', 'uri' => '/account', 'handler' => [AccountController::class, 'index'], 'middleware' => [AuthMiddleware::class]]
```

## Add a service method

```php
public function changePassword(int $userId, string $newPassword): void
{
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $this->users->updatePassword($userId, $hash);
}
```

## Add a policy check

```php
Gate::define('manage-users', fn (string $role): bool => $role === 'admin');
if (!Gate::allows('manage-users', Auth::role())) {
    return new Response('Forbidden', 403);
}
```
