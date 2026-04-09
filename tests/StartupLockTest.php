<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Core\StartupLock;

final class StartupLockTest extends TestCase
{
    public function testStartupLockWriteAndExists(): void
    {
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mvc-core-startup-lock-test.lock';
        if (file_exists($path)) {
            unlink($path);
        }

        $lock = new StartupLock($path);
        self::assertFalse($lock->exists());
        $lock->write();
        self::assertTrue($lock->exists());
        unlink($path);
    }
}
