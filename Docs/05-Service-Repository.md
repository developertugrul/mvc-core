# Service and Repository

## Why this split

- Controller: HTTP input/output only
- Service: business rules and orchestration
- Repository: persistence only

## Example

Register flow:

```text
AuthController::register
  -> AuthService::register
    -> UserRepository::create
```

## Repository rules

- Use prepared statements only.
- Keep SQL in repository layer.
- Return simple arrays/DTOs for service consumption.

## Service rules

- Validate business intent.
- Compose multiple repositories when needed.
- Throw domain-level exceptions (not HTTP response directly).
