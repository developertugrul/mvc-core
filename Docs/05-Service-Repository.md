# Service and Repository

## Layering

- Controllers orchestrate HTTP concerns.
- Services hold business logic.
- Repositories isolate database access.

## Example Flow

`AuthController::register()` -> `AuthService::register()` -> `UserRepository::create()`

Benefits:

- better testability
- reduced controller complexity
- reusable domain logic
