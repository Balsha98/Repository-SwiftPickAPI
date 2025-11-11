<?php

namespace Source\Handlers\Routing;

class Routes
{
    private static array $routes = [
        'GET' => [
            'categories',
            'products'
        ],
        'POST' => [],
        'PUT' => [],
        'DELETE' => []
    ];

    public static function fetchRoute(string $method)
    {
        return self::$routes[$method];
    }
}
