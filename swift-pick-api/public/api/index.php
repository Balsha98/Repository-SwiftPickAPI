<?php

require_once __DIR__ . '/source/autoload.php';

// Imported classes.
use Source\Handlers\Routing\Routes;
// use Source\Helpers\Classes\Debugger;
use Source\Helpers\Classes\Encoder;

try {
    $allowedRoutes = [];
    $method = $_SERVER['REQUEST_METHOD'];

    // Set appropriate response header.
    header('Content-Type: application/json');

    // Guard clause.
    if (is_null(Routes::fetchRoute($method))) {
        throw new Exception('Request method is not supported!');
    }

    $allowedRoutes = Routes::fetchRoute($method);
    $uriParts = explode('/', $_SERVER['REQUEST_URI']);
    array_shift($uriParts);

    $lastUriIndex = count($uriParts) - 1;

    // Guard clause.
    if ($uriParts[$lastUriIndex] === 'api') {
        throw new Exception('Please specify a resource...');
    }

    // Get targeted resource.
    $resourceName = $uriParts[1];

    // Check if resource co-relates to a valid API route.
    if (!in_array($resourceName, $allowedRoutes)) {
        throw new Exception('Unidentifiable resource given...');
    }

    $filePath = __DIR__ . "/assets/content/{$resourceName}.json";
    $resourceData = Encoder::decodeFromJSON(file_get_contents($filePath));

    // Check for ID.
    if (is_numeric($uriParts[$lastUriIndex])) {
        $resourceID = $uriParts[$lastUriIndex];

        $itemIDs = [];
        foreach ($resourceData as $data) {
            $itemIDs[] = (int) $data['id'];

            if ((int) $data['id'] === (int) $resourceID) {
                $resourceData = $data;

                break;
            }
        }

        // Check if ID exists.
        if (!in_array($resourceID, $itemIDs)) {
            throw new Exception("{$resourceName}/{$resourceID} does not exist...");
        }
    }
} catch (Exception $e) {
    echo Encoder::encodeToJSON('error', $e->getMessage());

    die();
}

// Print result.
echo Encoder::encodeToJSON('success', $resourceData);
