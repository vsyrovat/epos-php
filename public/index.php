<?php

use App\Core\Application;
use App\Core\Container;
use App\Core\Router;
use App\Core\Templator;
use App\Data\GetOrdersDataProvider;
use App\Http\DefaultController;
use App\Http\OrderController;

require_once dirname(__DIR__).'/vendor/autoload.php';

$env = parse_ini_file(dirname(__DIR__).'/.env');

$router = new Router();
$router->get('/', [DefaultController::class, 'home']);
$router->get('/orders-json', [OrderController::class, 'getJson']);
$router->get('/orders-html', [OrderController::class, 'getHtml']);

$container = new Container();

$container->add(Router::class, $router);

$container->add(OrderController::class, new OrderController($container));
$container->add(DefaultController::class, new DefaultController($container));

$pdo = new PDO($env['PDO_DSN'].';charset=utf8', $env['PDO_USER'], $env['PDO_PASSWORD']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$container->add(PDO::class, $pdo);

$container->add(GetOrdersDataProvider::class, new GetOrdersDataProvider($container->get(PDO::class)));

$container->add(Templator::class, new Templator(realpath(dirname(__DIR__).'/src/Templates')));

$application = new Application($container);
$application->handleHttp();
