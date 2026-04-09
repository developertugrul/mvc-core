<?php

declare(strict_types=1);

namespace App\Application\Cron;

interface CronTaskInterface
{
    public function signature(): string;
    public function run(): void;
}
