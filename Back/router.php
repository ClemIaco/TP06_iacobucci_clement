<?php

use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Middlewares\CorsMiddleware;
use Slim\App;

return function (App $app) {

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        return $response;
    });
    $app->add(CorsMiddleware::class);

    $app->get('/', HomeController::class . ":home");   // Ou "App\Controllers\HomeController:home au lieu de HomeController::class

    $app->group('/user', function (Group $group) {
        $group->post('/login',  UserController::class . ":login");
        $group->post('/register',  UserController::class . ":register");
    });
};