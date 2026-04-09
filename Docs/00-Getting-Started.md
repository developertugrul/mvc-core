# Getting Started

## 1) Requirements

- PHP `8.5+`
- Composer `2.x`
- Node.js `18+`
- MySQL, PostgreSQL, or MSSQL PDO extension

## 2) Install

```bash
composer install
npm install
```

## 3) Environment

```bash
copy .env.example .env
```

Set at least:

- `APP_KEY`
- `DB_CONNECTION`
- `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`

## 4) Database init

Manual:

```bash
composer run migrate-seed
```

Auto first-boot:

- set `AUTO_MIGRATE_ON_BOOT=true`
- open app once
- lock file is created at `storage/bootstrap/migrated.lock`

## 5) Build assets

```bash
npm run build
```

## 6) Run checks

```bash
php scripts/deploy-check.php
composer test
```
