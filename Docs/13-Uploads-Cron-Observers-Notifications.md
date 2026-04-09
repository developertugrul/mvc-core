# Uploads, Cron, Observers, Mail, Notifications

## 1) Public vs Private uploads

Upload targets:

- public files: `public/uploads`
- private files: `storage/private/uploads`

Service:

- `App\Application\Services\UploadService`

Example:

```php
$path = $uploadService->store($_FILES['avatar'], 'public');
```

Use `'private'` to keep files outside web root.

## 2) Example auth pages shipped

- Home
- Login
- Register
- Forgot password
- Confirm password
- Reset password
- Profile
- Admin dashboard
- Cookie policy
- Terms of use
- Privacy policy

## 3) Default middleware roles

- `AuthMiddleware`: authenticated user only
- `GuestMiddleware`: unauthenticated only
- `AdminMiddleware`: role must be `admin`
- `PermissionMiddleware`: checks route permission (falls back to admin)

Route example:

```php
['method' => 'GET', 'uri' => '/admin/reports', 'handler' => [DashboardController::class, 'index'], 'middleware' => [AuthMiddleware::class, PermissionMiddleware::class], 'permission' => 'reports.view']
```

## 4) Cron jobs

Runner:

```bash
php scripts/cron-runner.php
```

Cron entry (Linux hosting):

```cron
*/5 * * * * /usr/bin/php /home/USER/public_html/project/scripts/cron-runner.php >> /home/USER/cron.log 2>&1
```

Kernel:

- `App\Application\Cron\CronKernel`

Task example:

- `CleanupTempFilesTask`

## 5) Observer system

Dispatcher:

- `App\Core\Events\EventDispatcher`

Observer:

- `App\Application\Observers\UserRegisteredObserver`

Flow:

1. `AuthService::register()` dispatches `user.registered`
2. Observer creates verify-email notification
3. Notifier sends through configured channels

## 6) Mail classes and default template

Mail base:

- `App\Application\Mail\Mailable`

Mailer:

- `App\Application\Mail\Mailer` (Symfony Mailer)

Default verify mail:

- `App\Application\Mail\VerifyEmailMail`

Configure:

```env
MAIL_DSN=smtp://localhost
MAIL_FROM=no-reply@example.com
```

## 7) Notification channels

Implemented channels:

- mail
- sms (provider adapter)
- web_push (VAPID + service worker)
- in_app

Core classes:

- `Notifier`
- `VerifyEmailNotification`
- `Channels/*`

### Web Push (Chrome, Firebase'siz)

- Service worker: `public/sw.js`
- Browser izin akışı: `Enable browser notifications` butonu
- Subscription endpoint:
  - `POST /notifications/web-push/subscribe`
- Gönderim altyapısı:
  - `minishlink/web-push` + VAPID key
- VAPID key üretimi:
  - `composer run generate-vapid`

`.env`:

```env
WEBPUSH_SUBJECT=mailto:no-reply@example.com
WEBPUSH_PUBLIC_KEY=...
WEBPUSH_PRIVATE_KEY=...
```

### SMS provider destekleri

`SMS_PROVIDER` seçenekleri:

- `twilio`
- `vodafone`
- `turkcell`
- `turktelekom`

Twilio:

```env
TWILIO_SID=...
TWILIO_TOKEN=...
TWILIO_FROM=+1...
```

Operatör adapterları doküman bazlı payload ile ayrıştırılmıştır:

- `VodafoneSmsProvider`
- `TurkcellSmsProvider`
- `TurkTelekomSmsProvider`

Ortam değişkenleri:

```env
SMS_FROM=MYBRAND
VODAFONE_SMS_ENDPOINT=...
VODAFONE_SMS_TOKEN=...
TURKCELL_SMS_ENDPOINT=...
TURKCELL_SMS_TOKEN=...
TURKTELEKOM_SMS_ENDPOINT=...
TURKTELEKOM_SMS_TOKEN=...
```

Not:

- `SMS_FROM`, Vodafone/Turkcell/TurkTelekom adapterlari icin zorunludur.
- SMS gonderimi, kullaniciya ait telefon bilgisi varsa tetiklenir.

Payload format özeti:

- **Vodafone**
  - `sender`
  - `message`
  - `recipients[].msisdn`
- **Turkcell**
  - `from`
  - `to[]`
  - `text`
  - `encoding`
- **TurkTelekom**
  - `source_addr`
  - `destination_addr`
  - `message`
  - `is_unicode`

Guvenlik notu:

- Web-push payload'larinda hassas token/secret verileri tasinmaz.

## 8) Startup + migration behavior

First boot automation:

- `bootstrap/startup.php`
- lock file: `storage/bootstrap/migrated.lock`

Manual commands:

```bash
composer run migrate
composer run seed
composer run migrate-seed
```
