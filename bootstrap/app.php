<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use App\Core\Application;
use App\Core\Component\ComponentManager;
use App\Core\Component\ComponentRegistry;
use App\Core\Component\ComponentSigner;
use App\Core\Config;
use App\Core\Database;
use App\Core\ErrorHandler;
use App\Core\Events\EventDispatcher;
use App\Core\Router;
use App\Application\Components\CounterComponent;
use App\Application\Components\LanguageSwitcherComponent;
use App\Application\Mail\Mailer;
use App\Application\Notifications\Channels\InAppChannel;
use App\Application\Notifications\Channels\MailChannel;
use App\Application\Notifications\Channels\SmsChannel;
use App\Application\Notifications\Channels\WebPushChannel;
use App\Application\Notifications\Notifier;
use App\Application\Notifications\Sms\SmsManager;
use App\Application\Notifications\WebPush\WebPushService;
use App\Application\Observers\UserRegisteredObserver;
use App\Application\Services\UploadService;

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
    ComponentSigner::class => static fn () => new ComponentSigner($config->string('app_key', 'change-this-key')),
]);

$container = $containerBuilder->build();
global $appContainer;
$appContainer = $container;

$events = new EventDispatcher();
$container->set(EventDispatcher::class, $events);
$container->set(Mailer::class, new Mailer($config));
$container->set(MailChannel::class, new MailChannel($container->get(Mailer::class), $config));
$container->set(SmsManager::class, new SmsManager($config));
$container->set(WebPushService::class, new WebPushService($config));
$container->set(SmsChannel::class, new SmsChannel($container->get(SmsManager::class)));
$container->set(WebPushChannel::class, new WebPushChannel($container->get(WebPushService::class)));
$container->set(InAppChannel::class, new InAppChannel());
$container->set(Notifier::class, new Notifier(
    $container->get(MailChannel::class),
    $container->get(SmsChannel::class),
    $container->get(WebPushChannel::class),
    $container->get(InAppChannel::class)
));
$events->listen('user.registered', new UserRegisteredObserver($container->get(Notifier::class)));
$container->set(UploadService::class, new UploadService($config));
$container->get(UploadService::class)->ensureDirectories();

$registry = new ComponentRegistry($container);
$registry->register('counter', CounterComponent::class);
$registry->register('language-switcher', LanguageSwitcherComponent::class);
$container->set(ComponentRegistry::class, $registry);
$container->set(ComponentManager::class, new ComponentManager($registry, $container->get(ComponentSigner::class)));

ErrorHandler::register($container->get(Logger::class), (bool) $config->get('app_debug', false));

$router = new Router($container, $config);
$routes = require BASE_PATH . '/routes/web.php';
$apiRoutes = require BASE_PATH . '/routes/api.php';

$router->register($routes);
$router->register($apiRoutes);

return new Application($router, $container, $config);
