<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use App\Core\Config;
use App\Core\Database;
use App\Core\SqlFileRunner;
use App\Core\StartupLock;

require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();

$config = Config::fromEnv();
$lock = new StartupLock($config->storagePath('bootstrap/migrated.lock'));
$autoMigrate = ($_ENV['AUTO_MIGRATE_ON_BOOT'] ?? 'false') === 'true';
$isProduction = $config->string('app_env', 'production') === 'production';
if (!$lock->exists() && ($autoMigrate || !$isProduction)) {
    try {
        $runner = new SqlFileRunner(Database::makePdo($config));
        $runner->runDirectory(BASE_PATH . '/database/migrations');
        $runner->runDirectory(BASE_PATH . '/database/seeders');
        $lock->write();
    } catch (Throwable $e) {
        if (!is_dir($config->storagePath('logs'))) {
            mkdir($config->storagePath('logs'), 0775, true);
        }
        file_put_contents($config->storagePath('logs/startup.log'), '[' . date(DATE_ATOM) . '] ' . $e->getMessage() . PHP_EOL, FILE_APPEND);
    }
}
