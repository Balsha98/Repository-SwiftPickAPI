<?php

namespace Source\Handlers\Routing;

class Routes
{
    private static array $routes = [
        'GET' => [
            'categories',
            'collections',
            'products',
            'stores'
        ]
    ];

    public static function fetchRoute(string $method)
    {
        return self::$routes[$method];
    }
}
