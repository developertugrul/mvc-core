# Installation

## Prerequisites

- PHP `8.5+`
- Composer
- Node.js + npm
- DB driver extension:
  - `pdo_mysql` or
  - `pdo_pgsql` or
  - `pdo_sqlsrv`

## Setup steps

### Step 1: Dependencies

```bash
composer install
npm install
```

### Step 2: Environment

```bash
copy .env.example .env
```

Set DB driver:

```env
DB_CONNECTION=mysql
```

Alternatives: `pgsql`, `sqlsrv`.

### Step 3: Migrate and seed

```bash
composer run migrate-seed
```

### Step 4: Build frontend assets

```bash
npm run build
```

### Step 5: Document root

Point web root to `public/`.

## First-boot auto migration

If you want automatic first-run migration/seeding:

```env
AUTO_MIGRATE_ON_BOOT=true
```

After first successful run, app writes:

- `storage/bootstrap/migrated.lock`
