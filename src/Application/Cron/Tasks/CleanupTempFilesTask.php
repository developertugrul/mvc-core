<?php

declare(strict_types=1);

namespace App\Application\Cron\Tasks;

use App\Application\Cron\CronTaskInterface;

final class CleanupTempFilesTask implements CronTaskInterface
{
    public function signature(): string
    {
        return 'cleanup:temp-files';
    }

    public function run(): void
    {
        $path = BASE_PATH . '/storage/cache';
        if (!is_dir($path)) {
            return;
        }
        foreach (glob($path . '/*') ?: [] as $file) {
            if (is_file($file) && basename($file) !== '.gitkeep' && filemtime($file) < time() - 86400) {
                @unlink($file);
            }
        }
    }
}
