# Advanced Features

## Multi-language

- Default enabled locales: `tr,en`
- Optional locale prefix routes:
  - `/dashboard`
  - `/tr/dashboard`
  - `/en/dashboard`
- Language settings page: `/settings/language`

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
