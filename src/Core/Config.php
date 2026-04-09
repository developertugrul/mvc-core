<?php

declare(strict_types=1);

namespace App\Core;

final class Config
{
    public function __construct(private array $items)
    {
    }

    public static function fromEnv(): self
    {
        return new self([
            'app_env' => $_ENV['APP_ENV'] ?? 'production',
            'app_debug' => ($_ENV['APP_DEBUG'] ?? 'false') === 'true',
            'app_url' => $_ENV['APP_URL'] ?? 'http://localhost',
            'app_key' => $_ENV['APP_KEY'] ?? 'change-this-key',
            'default_locale' => $_ENV['APP_LOCALE'] ?? 'tr',
            'fallback_locale' => $_ENV['APP_FALLBACK_LOCALE'] ?? 'en',
            'enabled_locales' => array_values(array_filter(array_map('trim', explode(',', (string) ($_ENV['APP_ENABLED_LOCALES'] ?? 'tr,en'))))),
            'db_host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
            'db_port' => $_ENV['DB_PORT'] ?? '3306',
            'db_name' => $_ENV['DB_NAME'] ?? 'mvc_core',
            'db_user' => $_ENV['DB_USER'] ?? 'root',
            'db_pass' => $_ENV['DB_PASS'] ?? '',
            'db_charset' => $_ENV['DB_CHARSET'] ?? 'utf8mb4',
            'db_connection' => $_ENV['DB_CONNECTION'] ?? 'mysql',
            'session_secure_cookie' => ($_ENV['SESSION_SECURE_COOKIE'] ?? 'false') === 'true',
            'upload_max_size_mb' => (int) ($_ENV['UPLOAD_MAX_SIZE_MB'] ?? 5),
            'mail_dsn' => $_ENV['MAIL_DSN'] ?? 'smtp://localhost',
            'mail_from' => $_ENV['MAIL_FROM'] ?? 'no-reply@example.com',
            'webpush_subject' => $_ENV['WEBPUSH_SUBJECT'] ?? 'mailto:no-reply@example.com',
            'webpush_public_key' => $_ENV['WEBPUSH_PUBLIC_KEY'] ?? '',
            'webpush_private_key' => $_ENV['WEBPUSH_PRIVATE_KEY'] ?? '',
            'sms_provider' => $_ENV['SMS_PROVIDER'] ?? 'twilio',
            'sms_from' => $_ENV['SMS_FROM'] ?? '',
            'twilio_sid' => $_ENV['TWILIO_SID'] ?? '',
            'twilio_token' => $_ENV['TWILIO_TOKEN'] ?? '',
            'twilio_from' => $_ENV['TWILIO_FROM'] ?? '',
            'vodafone_sms_endpoint' => $_ENV['VODAFONE_SMS_ENDPOINT'] ?? '',
            'vodafone_sms_token' => $_ENV['VODAFONE_SMS_TOKEN'] ?? '',
            'turkcell_sms_endpoint' => $_ENV['TURKCELL_SMS_ENDPOINT'] ?? '',
            'turkcell_sms_token' => $_ENV['TURKCELL_SMS_TOKEN'] ?? '',
            'turktelekom_sms_endpoint' => $_ENV['TURKTELEKOM_SMS_ENDPOINT'] ?? '',
            'turktelekom_sms_token' => $_ENV['TURKTELEKOM_SMS_TOKEN'] ?? '',
        ]);
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->items[$key] ?? $default;
    }

    public function string(string $key, string $default = ''): string
    {
        return (string) ($this->items[$key] ?? $default);
    }

    public function bool(string $key, bool $default = false): bool
    {
        return (bool) ($this->items[$key] ?? $default);
    }

    public function int(string $key, int $default = 0): int
    {
        return (int) ($this->items[$key] ?? $default);
    }

    /** @return array<int, string> */
    public function stringArray(string $key, array $default = []): array
    {
        $value = $this->items[$key] ?? $default;
        if (!is_array($value)) {
            return $default;
        }
        return array_values(array_map('strval', $value));
    }

    public function basePath(string $path = ''): string
    {
        return BASE_PATH . ($path === '' ? '' : '/' . ltrim($path, '/'));
    }

    public function storagePath(string $path = ''): string
    {
        return $this->basePath('storage/' . ltrim($path, '/'));
    }
}
