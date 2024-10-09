<?php

require_once '../vendor/autoload.php';

use Core\Router;
$router = new Router();

$router->add('', ['controller' => 'App\Controllers\HomeController', 'action' => 'index']);
$router->add('transaction', ['controller' => 'App\Controllers\TransactionController', 'action' => 'index']);
$router->add('login', ['controller' => 'App\Controllers\LoginController', 'action' => 'index']);
$router->add('register', ['controller' => 'App\Controllers\LoginController', 'action' => 'register']);


$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($url);
