# Examples

## Example 1: New localized protected route

```php
['method' => 'GET', 'uri' => '/account', 'handler' => [AccountController::class, 'index'], 'middleware' => [AuthMiddleware::class]]
```

This becomes available as:

- `/account`
- `/tr/account`
- `/en/account`

## Example 2: Component render in view

```php
<?= component('counter', ['start' => 5]); ?>
```

## Example 3: Translatable entity

```php
$content->setTranslation('title', 'tr', 'Baslik');
$content->setTranslation('title', 'en', 'Title');
echo $content->translate('title', 'tr', 'en');
```

## Example 4: Export CSV

```php
$path = BASE_PATH . '/storage/cache/report.csv';
$this->documents->exportCsv($rows, $path);
return Response::download($path, 'report.csv', 'text/csv; charset=UTF-8');
```
