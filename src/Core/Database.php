<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

final class Database
{
    public static function makePdo(Config $config): PDO
    {
        $driver = (string) $config->get('db_connection', 'mysql');
        $dsn = match ($driver) {
            'pgsql' => sprintf(
                'pgsql:host=%s;port=%s;dbname=%s',
                $config->get('db_host'),
                $config->get('db_port'),
                $config->get('db_name')
            ),
            'sqlsrv' => sprintf(
                'sqlsrv:Server=%s,%s;Database=%s',
                $config->get('db_host'),
                $config->get('db_port'),
                $config->get('db_name')
            ),
            default => sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config->get('db_host'),
                $config->get('db_port'),
                $config->get('db_name'),
                $config->get('db_charset')
            ),
        };

        return new PDO($dsn, (string) $config->get('db_user'), (string) $config->get('db_pass'), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }
}
