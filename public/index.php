<?php

require_once '../vendor/autoload.php';
use Core\Router;

$router = new Router();


$router->add('home', ['controller' => 'App\Controllers\HomeController', 'action' => 'index']);
$router->add('login', ['controller' => 'App\Controllers\LoginController', 'action' => 'index'], 'GET');
$router->add('login', ['controller' => 'App\Controllers\LoginController', 'action' => 'login'], 'POST');
$router->add('register', ['controller' => 'App\Controllers\RegisterController', 'action' => 'register'], 'GET');  // Route to show the registration form
$router->add('register', ['controller' => 'App\Controllers\RegisterController', 'action' => 'register'], 'POST'); // Route to handle form submission
$router->add('captcha', ['controller' => 'App\Controllers\CaptchaController', 'action' => 'generate']);
$router->add('logout', ['controller' => 'App\Controllers\LoginController', 'action' => 'logout']);
$router->add('peminjaman', ['controller' => 'App\Controllers\PeminjamanController', 'action' => 'index']);
$router->add('peminjaman/save', ['controller' => 'App\Controllers\PeminjamanController', 'action' => 'save'], 'POST');
$router->add('peminjaman/delete/{id}', ['controller' => 'App\Controllers\PeminjamanController', 'action' => 'delete']);



$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = str_replace('/websitefinalpwe/public/', '', $url);
$router->dispatch($url);
