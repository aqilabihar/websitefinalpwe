<?php

require_once '../vendor/autoload.php';
use Core\Router;

$router = new Router();

$router->add('', ['controller' => 'App\Controllers\RegisterController', 'action' => 'index']);
$router->add('login', ['controller' => 'App\Controllers\LoginController', 'action' => 'index']);



$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = str_replace('/websitefinalpwe/public/', '', $url);
$router->dispatch($url);
