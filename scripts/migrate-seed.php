<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap-cli.php';

$runner->runDirectory(BASE_PATH . '/database/migrations');
$runner->runDirectory(BASE_PATH . '/database/seeders');
echo "Migrate + seed completed." . PHP_EOL;
