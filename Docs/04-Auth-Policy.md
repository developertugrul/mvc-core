# Auth and Policy

## Auth flow

1. `AuthController::login()` receives credentials.
2. `AuthService::attempt()` loads user via repository.
3. `Auth::attempt()` validates password hash.
4. Session stores:
   - `user_id`
   - `role`

Logout:

- `Auth::logout()` clears session and regenerates id.

## Route protection

- Guest-only pages use `GuestMiddleware`.
- Protected pages use `AuthMiddleware`.

## Policy and gate

`UserPolicy` contains role rules.

Example:

```php
Gate::define('view-admin-dashboard', fn (string $role): bool => $policy->viewAdminDashboard($role));
if (!Gate::allows('view-admin-dashboard', Auth::role())) {
    return new Response('Forbidden', 403);
}
```

## Best practice

- Keep authorization logic out of controllers when possible.
- Add one policy method per business ability.
