<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use App\Core\Application;
use App\Core\Config;
use App\Core\Database;
use App\Core\ErrorHandler;
use App\Core\Router;

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();

$config = Config::fromEnv();
global $appConfig;
$appConfig = $config;
require_once BASE_PATH . '/src/Core/helpers.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([
    Config::class => $config,
    Logger::class => static function () use ($config): Logger {
        $logger = new Logger('app');
        $logger->pushHandler(new StreamHandler($config->storagePath('logs/app.log'), Level::Info));
        return $logger;
    },
    PDO::class => static fn () => Database::makePdo($config),
]);

$container = $containerBuilder->build();

ErrorHandler::register($container->get(Logger::class), (bool) $config->get('app_debug', false));

$router = new Router($container, $config);
$routes = require BASE_PATH . '/routes/web.php';
$apiRoutes = require BASE_PATH . '/routes/api.php';

$router->register($routes);
$router->register($apiRoutes);

return new Application($router, $container, $config);
