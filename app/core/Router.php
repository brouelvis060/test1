<?php
declare(strict_types=1);

namespace App\Core;

use App\Helpers\Str;

final class Router
{
    /** @var array<string, array<string, string>> */
    private array $routes = ['GET' => [], 'POST' => []];

    public function get(string $path, string $handler): void
    {
        $this->routes['GET'][$this->normalize($path)] = $handler;
    }

    public function post(string $path, string $handler): void
    {
        $this->routes['POST'][$this->normalize($path)] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        $method = strtoupper($method);
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $path = $this->normalize($path);

        $handler = $this->routes[$method][$path] ?? null;
        if ($handler === null) {
            http_response_code(404);
            echo '404 - Page introuvable';
            return;
        }

        [$controller, $action] = Str::explodeOnce($handler, '@');
        $controllerClass = 'App\\Controllers\\' . $controller;

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            echo 'Erreur: contrôleur introuvable.';
            return;
        }

        $instance = new $controllerClass();
        if (!method_exists($instance, $action)) {
            http_response_code(500);
            echo 'Erreur: action introuvable.';
            return;
        }

        $instance->$action();
    }

    private function normalize(string $path): string
    {
        $path = '/' . trim($path, '/');
        return $path === '//' ? '/' : $path;
    }
}

