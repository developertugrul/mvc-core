# Migrations and Seeders Auto-Run

## Manual commands

```bash
composer run migrate
composer run seed
composer run migrate-seed
composer run cron
```

## First boot lock flow

Startup file: `bootstrap/startup.php`

Rules:

1. If lock file exists, skip.
2. If lock missing:
   - production: run only when `AUTO_MIGRATE_ON_BOOT=true`
   - non-production: run by default
3. On success, write lock:
   - `storage/bootstrap/migrated.lock`
4. On failure, write error to:
   - `storage/logs/startup.log`

## Reset lock

To force rerun:

1. delete `storage/bootstrap/migrated.lock`
2. restart app request
