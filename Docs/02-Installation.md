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

Windows:

```powershell
copy .env.example .env
```

Linux/macOS:

```bash
cp .env.example .env
```

Set DB driver:

```env
DB_CONNECTION=mysql
```

Alternatives: `pgsql`, `sqlsrv`.

Generate strong `APP_KEY` and set it in `.env`:

PowerShell:

```powershell
php -r "echo bin2hex(random_bytes(32)), PHP_EOL;"
```

Bash:

```bash
php -r 'echo bin2hex(random_bytes(32)), PHP_EOL;'
```

### Step 3: Migrate and seed

Create your database/schema first, then run:

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
