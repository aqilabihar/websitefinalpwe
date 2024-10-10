<?php

namespace Core;

use App\Models\ScheduleModel;  // Add this line to import ScheduleModel

class Router {
    private $routes = [];

    public function add($route, $params = [], $method = 'GET') {
        $this->routes[$method][$route] = $params;
    }

    public function dispatch($url) {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = ltrim($url, '/');

        if (isset($this->routes[$method][$url])) {
            $params = $this->routes[$method][$url];
            $controller = $params['controller'];
            $action = $params['action'];

            if (class_exists($controller)) {
                if ($controller === 'App\Controllers\ScheduleController') {
                    require_once '../app/database/Koneksi.php';

                    // Instantiate ScheduleModel from the fully qualified namespace
                    $db = \App\Database\Koneksi::getConnection();
                    $model = new ScheduleModel($db);  // Ensure correct instantiation

                    $controllerObject = new $controller($model);
                } else {
                    $controllerObject = new $controller();
                }

                if (method_exists($controllerObject, $action)) {
                    $controllerObject->$action();
                } else {
                    echo "Method $action not found in $controller";
                }
            } else {
                echo "Controller class $controller not found.";
            }
        } else {
            echo "No route matched.";
        }
    }
}
