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

    // Remove the first item from the array.
    array_shift($uriParts);

    $numUriParts = count($uriParts);

    // Guard clause.
    if ($numUriParts < 2) {
        throw new Exception('Please specify a resource...');
    }

    // Get targeted resource.
    $resourceName = $uriParts[1];

    // Check if content file exists.
    $filePath = __DIR__ . "/assets/content/{$resourceName}.json";
    if (!file_exists($filePath)) {
        throw new Exception('Unidentifiable resource given...');
    }

    $targetData = Encoder::decodeFromJSON(file_get_contents($filePath));

    // Check for ID.
    if ($numUriParts === 4) {
        $resourceID = $uriParts[3];

        $itemIDs = [];
        foreach ($targetData as $data) {
            $itemIDs[] = (int) $data['id'];

            if ((int) $data['id'] === (int) $resourceID) {
                $targetData = $data;

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
echo Encoder::encodeToJSON('success', $targetData);
