# Architecture

## Folder model

- `public/` web root (`index.php`, static assets)
- `bootstrap/` startup and app wiring
- `src/Core/` framework primitives
- `src/Application/` controllers, middleware, services, components, views
- `routes/` route tables
- `database/` SQL migrations and seeders
- `storage/` logs, cache, runtime locks

## Request pipeline

1. `public/index.php` loads autoload + `bootstrap/startup.php`.
2. Startup optionally runs migration/seeder once (lock-based).
3. `bootstrap/app.php` builds DI container and router.
4. Router matches route and collects middleware.
5. Middleware pipeline runs.
6. Controller or component endpoint returns `Response`.

## Component pipeline (Livewire-like)

1. Initial page render includes `component('counter')` output.
2. Component HTML contains signed payload (`data-payload`, `data-signature`).
3. Browser sends POST to `/_components/{name}/{action}`.
4. Server verifies signature, hydrates state, calls action, re-renders component.
5. JSON response returns `html`, new signed payload, and signature.
