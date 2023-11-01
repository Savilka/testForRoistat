<?php

use App\Controllers\HomeController;
use App\Controllers\RequestController;
use DI\Bridge\Slim\Bridge;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

$app = Bridge::create();

$app->addBodyParsingMiddleware();


$app->get('/', [HomeController::class, 'home']);

$app->group('/api', function (RouteCollectorProxy $group) {
    $group->post('/createRequest', [RequestController::class, 'store']);
});

$app->run();
