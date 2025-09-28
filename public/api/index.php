<?php

require_once __DIR__ . '/source/autoload.php';

// Imported classes.
use Source\Classes\Routes;
use Source\Helpers\Classes\{Debugger, Encoder};

try {
    $allowedRoutes = [];
    $method = $_SERVER['REQUEST_METHOD'];

    if (is_null(Routes::$routes[$method])) {
        throw new Exception('Request method is not supported!');
    }

    $allowedRoutes = Routes::$routes[$method];
    $uriParts = explode('/', $_SERVER['REQUEST_URI']);
    $resourceName = $uriParts[2];
    $numUriParts = count($uriParts);

    // Check if content file exists.
    $filePath = __DIR__ . "/assets/content/{$resourceName}.json";
    if (!file_exists($filePath)) {
        throw new Exception('Unidentifiable resource given...');
    }

    $targetContent = file_get_contents($filePath);

    // Check for ID.
    if ($numUriParts === 4) {
        $resourceID = $uriParts[3];
        $targetData = Encoder::decodeFromJSON($targetContent);
        $itemIDs = [];

        foreach ($targetData as $data) {
            if ((int) $data['id'] === (int) $resourceID) {
                $targetContent = Encoder::encodeToJSON($data);
            }

            $itemIDs[] = (int) $data['id'];
        }

        // Check if ID exists.
        if (!in_array($resourceID, $itemIDs)) {
            throw new Exception("ResourceID({$resourceID}) does not exist...");
        }
    }
} catch (Exception $e) {
    echo $e->getMessage();

    die();
}

// Print result.
echo $targetContent;
