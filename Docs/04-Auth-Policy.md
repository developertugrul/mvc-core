# Auth and Policy

## Auth

Session-based auth is implemented in `src/Core/Auth.php`.

- Login via `AuthService::attempt()`
- Logout via `Auth::logout()`
- Session keys: `user_id`, `role`

## Policy and Gate

Policies live in `src/Application/Policies`.

`UserPolicy` example:

- `viewAdminDashboard(string $role): bool`

Gate usage:

```php
Gate::define('view-admin-dashboard', fn (string $role) => $this->policy->viewAdminDashboard($role));
$allowed = Gate::allows('view-admin-dashboard', Auth::role());
```
