# Installation

## Requirements

- PHP `8.5`
- Composer `2.x`
- MySQL `8+` or MariaDB equivalent
- Extensions: `pdo_mysql`, `mbstring`, `openssl`, `json`

## Steps

1. Install dependencies:
   - `composer install`
2. Copy env:
   - Windows: `copy .env.example .env`
3. Configure DB in `.env`.
4. Run SQL file:
   - `database/migrations/001_create_users_table.sql`
5. Set document root to `public/`.

## Local Run (XAMPP)

- Put project under `htdocs`.
- Use Apache virtual host or access via configured host.
