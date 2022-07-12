<?php

namespace App\Core;

use Exception;

class Router
{
    /**
     * All registered web.
     *
     * @var array
     */
    public array $routes = [
        'GET' => [],
        'POST' => []
    ];

    public array $routeNames = [];

    /**
     * Load a user's web file.
     *
     * @param string $file
     */
    public static function load($file): static
    {
        $router = new static();

        require $file;

        return $router;
    }

    /**
     * Register a GET route.
     *
     * @param  string  $uri
     * @param  array  $controllerWithAction
     */
    public function get(string $uri, array $controllerWithAction)
    {
        $uri = trim($uri, '/');
        $this->routes['GET'][$uri] = $controllerWithAction;
        if(strpos($uri, '{')){
//            $this->routes['GET'][$uri]['params'] = explode('/', $uri)[1];
        }
        return $this;
    }

    /**
     * Register a POST route.
     *
     * @param  string  $uri
     * @param  array  $controllerWithAction
     */
    public function post(string $uri, array $controllerWithAction)
    {
        $uri = trim($uri, '/');
        $this->routes['POST'][$uri] = $controllerWithAction;
        return $this;
    }

    /**
     * Load the requested URI's associated controller method.
     *
     * @param  string  $uri
     * @param  string  $requestType
     */
    public function direct(string $uri, string $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction($this->routes[$requestType][$uri]);
        }

        $explodedUri = explode('/', $uri);
        $uri = $this->resolveRouteParam($explodedUri);
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction($this->routes[$requestType][$uri], $explodedUri[1]);
        }

        throw new Exception('No route defined for this URI.');
    }

    protected function resolveRouteParam($explodedUri)
    {
        $key = $explodedUri[0] === 'blog' ? '{id}' : '{id}';
        return $explodedUri[0]."/$key";
    }

    /**
     * Load and call the relevant controller action.
     *
     * @param  array  $controllerWithAction
     * @throws Exception
     */
    protected function callAction(array $controllerWithAction, ...$params)
    {
        if (count($controllerWithAction) !== 2) {
            throw new Exception(
                "Missing Route Controller Name And Action"
            );
        } else {
            $controller = $controllerWithAction[0];
            $action = $controllerWithAction[1];
        }

        $controller = new $controller();
        if (! method_exists($controller, $action)) {
            throw new Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return $controller->$action($params);
    }
}
