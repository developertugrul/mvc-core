<?php

declare(strict_types=1);

namespace App\Core;

use DI\Container;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

final class Router
{
    private array $routeDefinitions = [];

    public function __construct(private Container $container, private Config $config)
    {
    }

    public function register(array $routes): void
    {
        $this->routeDefinitions = [...$this->routeDefinitions, ...$routes];
    }

    public function dispatch(Request $request): Response
    {
        $dispatcher = simpleDispatcher(function (RouteCollector $collector): void {
            foreach ($this->routeDefinitions as $route) {
                $collector->addRoute($route['method'], $route['uri'], $route);
            }
        });

        $result = $dispatcher->dispatch($request->method, $request->uri);

        if ($result[0] === Dispatcher::NOT_FOUND) {
            return new Response('Not Found', 404);
        }
        if ($result[0] === Dispatcher::METHOD_NOT_ALLOWED) {
            return new Response('Method Not Allowed', 405);
        }

        /** @var array $route */
        $route = $result[1];
        $vars = $result[2];
        foreach ($vars as $key => $value) {
            $request = $request->withAttribute((string) $key, $value);
        }
        $handler = $route['handler'];
        $middlewares = $route['middleware'] ?? [];
        if (isset($route['permission'])) {
            $request = $request->withAttribute('permission', (string) $route['permission']);
        }

        $pipeline = array_reduce(
            array_reverse($middlewares),
            function (callable $next, string $middlewareClass): callable {
                return function (Request $request) use ($middlewareClass, $next): Response {
                    $middleware = $this->container->get($middlewareClass);
                    return $middleware->handle($request, $next);
                };
            },
            function (Request $request) use ($handler, $vars): Response {
                [$controllerClass, $method] = $handler;
                $controller = $this->container->get($controllerClass);
                return $controller->{$method}($request, ...array_values($vars));
            }
        );

        return $pipeline($request);
    }
}
