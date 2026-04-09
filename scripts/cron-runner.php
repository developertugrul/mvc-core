<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));
require BASE_PATH . '/vendor/autoload.php';

use App\Application\Cron\CronKernel;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();

if (($_ENV['CRON_ENABLED'] ?? 'true') !== 'true') {
    echo "Cron is disabled by configuration." . PHP_EOL;
    exit(0);
}

$kernel = new CronKernel();
$kernel->runAll();
echo "Cron tasks completed." . PHP_EOL;
