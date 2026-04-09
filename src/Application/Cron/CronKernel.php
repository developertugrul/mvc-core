<?php

declare(strict_types=1);

namespace App\Application\Cron;

use App\Application\Cron\Tasks\CleanupTempFilesTask;

final class CronKernel
{
    /** @return array<int, CronTaskInterface> */
    public function tasks(): array
    {
        return [
            new CleanupTempFilesTask(),
        ];
    }

    public function runAll(): void
    {
        foreach ($this->tasks() as $task) {
            $task->run();
        }
    }
}
