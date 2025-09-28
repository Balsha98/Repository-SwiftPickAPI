<?php

require_once __DIR__ . '/source/autoload.php';

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

    // Check if content file exists.
    $filePath = __DIR__ . '/assets/content/' . $uriParts[2] . '.json';
    if (!file_exists($filePath)) {
        throw new Exception('Unidentifiable resource given...');
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
