<?php

namespace Core;

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
                $controllerObject = new $controller();
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


