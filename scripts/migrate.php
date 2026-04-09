<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap-cli.php';

$runner->runDirectory(BASE_PATH . '/database/migrations');
echo "Migrations completed." . PHP_EOL;
