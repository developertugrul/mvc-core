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

## Quick Start

1. Install dependencies:
   - `composer install`
   - `npm install` (optional)
2. Create env:
   - `copy .env.example .env`
3. Set your DB credentials in `.env`.
4. Create `users` table with:
   - `database/migrations/*.sql`
5. Point web root to `public/`.
6. Run deploy checks:
   - `php scripts/deploy-check.php`

## Routes

- `GET /` home
- `GET|POST /login`
- `GET|POST /register`
- `POST /logout`
- `GET /dashboard` (auth required)
- `GET|POST /settings/language`
- `GET /export/pdf|xlsx|csv`
- `POST /import/csv`

## Tests

- `composer test`

## Docs

Detailed docs are under `Docs/`.
