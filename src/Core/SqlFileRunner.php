<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

final class SqlFileRunner
{
    public function __construct(private PDO $pdo)
    {
    }

    public function runDirectory(string $path): void
    {
        $files = glob(rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '*.sql') ?: [];
        sort($files);

        foreach ($files as $file) {
            $sql = file_get_contents($file);
            if ($sql === false || trim($sql) === '') {
                continue;
            }
            $this->pdo->exec($sql);
        }
    }
}
