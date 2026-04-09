<?php

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

use Dotenv\Dotenv;
use App\Core\Config;
use App\Core\Database;
use App\Core\SqlFileRunner;

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();

$config = Config::fromEnv();
$pdo = Database::makePdo($config);
$runner = new SqlFileRunner($pdo);
