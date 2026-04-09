# PHP 8.5 MVC Core Starter

Shared-hosting friendly MVC starter with:

- PHP 8.5
- FastRoute based routing
- Middleware pipeline
- Session auth + policy/gate
- Service + repository separation
- `.env` based configuration
- Optional locale prefix routing (`/about` and `/tr/about`)
- TR/EN translations and language settings page
- MySQL/PostgreSQL/MSSQL PDO support
- Image, PDF, Excel, CSV helper services
- Public/private upload visibility model
- Observer, mail, and multi-channel notifications
- Cron runner and startup automation

## Quick Start

1. Install dependencies:
   - `composer install`
   - `npm install`
2. Create env:
   - `copy .env.example .env`
3. Set your DB credentials in `.env`.
4. Run database setup:
   - `composer run migrate-seed`
5. Point web root to `public/`.
6. Build assets:
   - `npm run build`
7. Run deploy checks:
   - `php scripts/deploy-check.php`

## Routes

- `GET /` home
- `GET|POST /login`
- `GET|POST /register`
- `GET|POST /forgot-password`
- `GET|POST /confirm-password`
- `GET|POST /reset-password`
- `GET /profile`
- `GET /verify-email`
- `POST /logout`
- `GET /dashboard` (auth required)
- `GET /admin/dashboard` (admin middleware)
- `GET|POST /settings/language`
- `GET /cookie-policy`
- `GET /terms-of-use`
- `GET /privacy-policy`
- `GET /export/pdf|xlsx|csv`
- `POST /import/csv`
- `POST /_components/{name}/{action}`

## Tests

- `composer test`
- `php scripts/cron-runner.php`

## Docs

Detailed docs are under `Docs/`:

- `Docs/00-Getting-Started.md`
- `Docs/01-Architecture.md`
- `Docs/02-Installation.md`
- `Docs/03-Routing-Middleware.md`
- `Docs/04-Auth-Policy.md`
- `Docs/05-Service-Repository.md`
- `Docs/06-Deployment-Shared-Hosting.md`
- `Docs/07-Examples.md`
- `Docs/08-Advanced-Features.md`
- `Docs/09-Components-System.md`
- `Docs/10-Tailwind-Setup.md`
- `Docs/11-Migrations-Seeders-AutoRun.md`
- `Docs/12-Security-Hardening-Checklist.md`
- `Docs/13-Uploads-Cron-Observers-Notifications.md`
