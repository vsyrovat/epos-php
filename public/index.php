<?php

use App\Core\Application;
use App\Core\Container;
use App\Core\Router;
use App\Core\Templator;
use App\Data\GetOrdersDataProvider;
use App\Data\ProductStorage;
use App\Http\DefaultController;
use App\Http\OrderController;
use App\Http\ProductController;

require_once dirname(__DIR__).'/vendor/autoload.php';

$env = parse_ini_file(dirname(__DIR__).'/.env');

$router = new Router();
$router->get('/', [DefaultController::class, 'home']);
$router->get('/orders-json', [OrderController::class, 'getJson']);
$router->get('/orders-html', [OrderController::class, 'getHtml']);
$router->get('/add-product', [ProductController::class, 'addProductForm']);
$router->post('/add-product', [ProductController::class, 'addProduct']);

$container = new Container();

$container->add(Router::class, $router);

$container->add(Templator::class, new Templator(realpath(dirname(__DIR__).'/src/Templates')));

$pdo = new PDO($env['PDO_DSN'].';charset=utf8', $env['PDO_USER'], $env['PDO_PASSWORD']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$container->add(PDO::class, $pdo);

$container->add(GetOrdersDataProvider::class, new GetOrdersDataProvider($container->get(PDO::class)));
$container->add(ProductStorage::class, new ProductStorage($container->get(PDO::class)));

$container->add(OrderController::class, new OrderController($container));
$container->add(DefaultController::class, new DefaultController);
$container->add(ProductController::class, new ProductController($container->get(Templator::class), $container->get(ProductStorage::class)));

$application = new Application($container);
$application->handleHttp();
