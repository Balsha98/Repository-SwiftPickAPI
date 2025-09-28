<?php

require_once __DIR__ . '/../../source/autoload.php';

// Imported classes.
use Source\Classes\{Router, Routes};
use Source\Helpers\Classes\{Debugger};

try {
    $allowedRoutes = [];
    $method = $_SERVER['REQUEST_METHOD'];

    if (!Routes::$routes[$method]) {
        throw new Exception('Request method is not supported!');
    }

    $allowedRoutes = Routes::$routes[$method];
    $uriParts = explode('/', $_SERVER['REQUEST_URI']);
    $partsLength = count($uriParts);
    $search = $uriParts[2];

    if ($partsLength === 3) {
    } else if ($partsLength === 4) {
    }

    print_r('Searching for: ' . $search);
} catch (Exception $e) {
    echo $e->getMessage();
}
