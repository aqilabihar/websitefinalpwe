<?php

namespace Core;

class Router {
    private $routes = [];

    // Add route
    public function add($route, $params = []) {
        $this->routes[$route] = $params;
    }


    public function dispatch($url) {
        $url = trim($url, '/');

        foreach ($this->routes as $route => $params) {
            if ($url === $route) {
                $controller = $params['controller'];
                $action = $params['action'];

                if (class_exists($controller)) {
                    $controllerObject = new $controller();
                    if (is_callable([$controllerObject, $action])) {
                        $controllerObject->$action();
                    } else {
                        echo "Method $action not found!<br>";
                    }
                } else {
                    echo "Controller class $controller not found!<br>";
                }
                return;
            }
        }
        echo "No route matched.<br>";
    }
}
