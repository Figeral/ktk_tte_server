<?php
class Router
{
    private array $routes = [];
    public function addController($controller)
    {
        $reflection = new ReflectionClass($controller);
        foreach ($reflection->getMethods() as $methods) {
            $attributes = $methods->getAttributes(Route::class);
            foreach ($attributes as $attribute) {
                $route = $attribute->newInstance();
                $this->routes[] = ['method' => $route->method, 'path' => $route->path, 'handler' => [$controller, $methods->getName()]];
            }
        }
    }
    private function matchPath($routePath, $requestPath)
    {
        $routeParts = explode('/', trim($routePath, '/'));
        $requestParts = explode('/', trim($requestPath, '/'));

        if (count($routeParts) !== count($requestParts)) {
            return false;
        }

        foreach ($routeParts as $index => $routePart) {
            if (strpos($routePart, '{') === 0 && strpos($routePart, '}') === strlen($routePart) - 1) {
                $_GET[trim($routePart, '{}')] = $requestParts[$index];
            } elseif ($routePart !== $requestParts[$index]) {
                return false;
            }
        }

        return true;
    }
    public function handleRequest($method, $path)
    {
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($route['path'], $path)) {
                //if true call the function by it name . 
                return call_user_func($route['handler']);
            }
        }
        http_response_code(404);
        return ['error' => 'Not Found'];
    }
}
