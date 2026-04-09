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
- sms (demo adapter)
- web_push (demo adapter)
- in_app

Core classes:

- `Notifier`
- `VerifyEmailNotification`
- `Channels/*`

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
