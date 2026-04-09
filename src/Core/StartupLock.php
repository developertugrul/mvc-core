<?php

declare(strict_types=1);

namespace App\Core;

final class StartupLock
{
    public function __construct(private string $lockPath)
    {
    }

    public function exists(): bool
    {
        return file_exists($this->lockPath);
    }

    public function write(): void
    {
        if (!is_dir(dirname($this->lockPath))) {
            mkdir(dirname($this->lockPath), 0775, true);
        }
        file_put_contents($this->lockPath, date(DATE_ATOM));
    }
}
