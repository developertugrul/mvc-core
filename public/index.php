<?php

declare(strict_types=1);

use App\Core\Application;

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';
require BASE_PATH . '/bootstrap/startup.php';

$app = require BASE_PATH . '/bootstrap/app.php';

$app->run();
