<?php

declare(strict_types=1);

namespace App\Core;

use DI\Container;

final class Application
{
    public function __construct(
        private Router $router,
        private Container $container,
        private Config $config
    ) {
    }

    public function run(): void
    {
        Session::boot($this->config);
        $request = Request::capture();
        $response = $this->router->dispatch($request);
        $response->send();
    }
}
