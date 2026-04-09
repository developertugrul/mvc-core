# Advanced Features

## Multi-language

- Default enabled locales: `tr,en`
- Optional locale prefix routes:
  - `/dashboard`
  - `/tr/dashboard`
  - `/en/dashboard`
- Language settings page: `/settings/language`
- Translation folders:
  - `lang/tr/*.php`
  - `lang/en/*.php`

## Spatie-like Translatable API

Use `App\Core\Concerns\HasTranslations`:

```php
$content->setTranslation('title', 'tr', 'Merhaba');
$content->setTranslation('title', 'en', 'Hello');
$text = $content->getTranslation('title', 'tr', 'en');
```

## DB Drivers

Set `.env`:

- `DB_CONNECTION=mysql`
- `DB_CONNECTION=pgsql`
- `DB_CONNECTION=sqlsrv`

## File Helpers

- `ImageHelper`: resize/crop/quality and upload-size guard
- `DocumentHelper`: PDF export, XLSX/CSV export, spreadsheet import

## Livewire-like components

- Base classes under `src/Core/Component`
- Endpoint:
  - `POST /_components/{name}/{action}`
- Signed payload prevents tampering.

## Auto migrate + seed

- `bootstrap/startup.php` runs once with lock:
  - `storage/bootstrap/migrated.lock`
