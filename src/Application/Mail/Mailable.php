<?php

declare(strict_types=1);

namespace App\Application\Mail;

abstract class Mailable
{
    abstract public function subject(): string;
    abstract public function html(): string;
}
