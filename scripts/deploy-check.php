<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$checks = [];
$checks[] = ['PHP >= 8.5', version_compare(PHP_VERSION, '8.5.0', '>=')];
$checks[] = ['pdo extension', extension_loaded('pdo')];
$checks[] = ['pdo_mysql OR pdo_pgsql OR pdo_sqlsrv', extension_loaded('pdo_mysql') || extension_loaded('pdo_pgsql') || extension_loaded('pdo_sqlsrv')];
$checks[] = ['mbstring extension', extension_loaded('mbstring')];
$checks[] = ['storage/logs writable', is_writable(__DIR__ . '/../storage/logs')];
$checks[] = ['storage/cache writable', is_writable(__DIR__ . '/../storage/cache')];
$checks[] = ['.env exists', file_exists(__DIR__ . '/../.env')];

$failed = false;
foreach ($checks as [$name, $ok]) {
    echo ($ok ? '[OK] ' : '[FAIL] ') . $name . PHP_EOL;
    if (!$ok) {
        $failed = true;
    }
}

exit($failed ? 1 : 0);
