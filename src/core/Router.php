<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes[] = ['GET', $path, $handler];
    }

    public function post(string $path, array $handler): void
    {
        $this->routes[] = ['POST', $path, $handler];
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        // bootstrap.php'de hesaplanan SCRIPT_BASE prefix'ini URI'den çıkar
        $base = defined('SCRIPT_BASE') ? SCRIPT_BASE : '';
        if ($base && $base !== '/' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }
        $uri = '/' . ltrim($uri, '/');

        foreach ($this->routes as [$routeMethod, $path, $handler]) {
            if ($routeMethod !== $method) {
                continue;
            }

            $pattern = preg_replace('#\{([a-zA-Z_]+)\}#', '([^/]+)', $path);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                [$class, $action] = $handler;
                $controller = new $class();
                $controller->$action(...$matches);
                return;
            }
        }

        http_response_code(404);
        view('errors/404');
    }
}
