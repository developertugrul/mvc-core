# Shared Hosting Deployment

## Production checklist

1. Upload code.
2. Run:
   - `composer install --no-dev --optimize-autoloader`
   - `npm ci && npm run build` (or upload built `public/assets`)
3. Configure `.env` with production values.
4. Set web root to `public/`.
5. Ensure writable:
   - `storage/logs`
   - `storage/cache`
   - `storage/sessions`
   - `storage/bootstrap`
6. Run health check:
   - `php scripts/deploy-check.php`

## Migration strategy

- Recommended: run once manually:
  - `composer run migrate-seed`
- Optional auto first-boot:
  - `AUTO_MIGRATE_ON_BOOT=true`
  - then switch back to `false`

## Security hardening

- `APP_DEBUG=false`
- strong `APP_KEY`
- `SESSION_SECURE_COOKIE=true` on HTTPS
- do not expose `.env` or `/storage` publicly
