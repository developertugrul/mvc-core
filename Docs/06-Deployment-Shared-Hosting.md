# Shared Hosting Deployment

## Recommended Deployment Steps

1. Upload project files.
2. Run `composer install --no-dev --optimize-autoloader`.
3. Copy `.env` and fill production values.
4. Import SQL migration.
5. Point domain/subdomain document root to `public/`.
6. Ensure these paths are writable:
   - `storage/logs`
   - `storage/cache`
   - `storage/sessions`

## Apache

`public/.htaccess` handles clean URL routing.

## Security Notes

- Keep `.env` outside public access (already outside `public/`).
- Set `APP_DEBUG=false` in production.
- Use HTTPS and `SESSION_SECURE_COOKIE=true`.
