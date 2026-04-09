<?php

declare(strict_types=1);

namespace App\Application\Notifications;

abstract class Notification
{
    /** @return array<int, string> */
    abstract public function channels(): array;
}
