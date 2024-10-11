<?php

require_once '../vendor/autoload.php';

use Core\Router;

// Initialize the router
$router = new Router();

<<<<<<< HEAD
// Add routes here
$router->add('', ['controller' => 'App\Controllers\RegisterController', 'action' => 'register']);
=======
<<<<<<< Updated upstream

=======
// Add routes here
$router->add('', ['controller' => 'App\Controllers\HomeController', 'action' => 'index']);
>>>>>>> Stashed changes
>>>>>>> MVC-Integration
$router->add('home', ['controller' => 'App\Controllers\HomeController', 'action' => 'index']);
$router->add('login', ['controller' => 'App\Controllers\LoginController', 'action' => 'index'], 'GET');
$router->add('login', ['controller' => 'App\Controllers\LoginController', 'action' => 'login'], 'POST');
$router->add('register', ['controller' => 'App\Controllers\RegisterController', 'action' => 'register'], 'GET');
$router->add('register', ['controller' => 'App\Controllers\RegisterController', 'action' => 'register'], 'POST');
$router->add('captcha', ['controller' => 'App\Controllers\CaptchaController', 'action' => 'generate']);
$router->add('logout', ['controller' => 'App\Controllers\LoginController', 'action' => 'logout']);
<<<<<<< HEAD
$router->add('peminjaman', ['controller' => 'App\Controllers\PeminjamanController', 'action' => 'index']);
$router->add('peminjaman/save', ['controller' => 'App\Controllers\PeminjamanController', 'action' => 'save'], 'POST');
$router->add('peminjaman/delete/{id}', ['controller' => 'App\Controllers\PeminjamanController', 'action' => 'delete']);


// Add the route for getSchedules
$router->add('getSchedules', ['controller' => 'App\Controllers\ScheduleController', 'action' => 'getSchedules']);

// Dispatch the URL
=======
<<<<<<< Updated upstream


=======
$router->add('peminjaman', ['controller' => 'App\Controllers\PeminjamanController', 'action' => 'index']);
$router->add('peminjaman/save', ['controller' => 'App\Controllers\PeminjamanController', 'action' => 'save'], 'POST');
$router->add('peminjaman/delete/{id}', ['controller' => 'App\Controllers\PeminjamanController', 'action' => 'delete']);
$router->add('getSchedules', ['controller' => 'App\Controllers\ScheduleController', 'action' => 'getSchedules']);

// Dispatch the URL
>>>>>>> Stashed changes
>>>>>>> MVC-Integration
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove base path '/websitefinalpwe/public/' from the URL to match the routes
$url = str_replace('/websitefinalpwe/public/', '', $url);

// Dispatch the router and check if it matches any routes
$router->dispatch($url);
