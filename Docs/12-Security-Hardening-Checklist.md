# Security Hardening Checklist

## App config

- [ ] `APP_DEBUG=false` in production
- [ ] strong unique `APP_KEY`
- [ ] `SESSION_SECURE_COOKIE=true` behind HTTPS

## Runtime protections

- [ ] CSRF enabled on mutating routes
- [ ] security headers middleware active
- [ ] rate limiting middleware active
- [ ] signed component payload verification active

## File handling

- [ ] upload size validation
- [ ] extension/mime validation before import
- [ ] store generated files outside direct listing contexts

## Deployment

- [ ] run `php scripts/deploy-check.php`
- [ ] do not expose `.env`
- [ ] only `public/` is document root

## Operations

- [ ] review `storage/logs/app.log` and `startup.log`
- [ ] run tests before release
- [ ] run `composer audit` regularly
