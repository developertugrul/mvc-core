# Architecture

This starter follows a hybrid architecture:

- `public/`: front controller and web server entry.
- `bootstrap/`: app initialization and container wiring.
- `src/Core`: framework core (request, response, router, auth, csrf, gate).
- `src/Application`: business layer (controllers, middleware, services, repositories, policies, views).
- `routes/`: route declarations (`web.php`, `api.php`, `console.php`).
- `storage/`: logs, sessions, caches.

Flow:

1. Request enters `public/index.php`.
2. `bootstrap/app.php` builds container + config + router.
3. Router resolves handler and executes middleware chain.
4. Controller calls service.
5. Service calls repository.
6. Repository persists/fetches from database.
