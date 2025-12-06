<?php

$directories = require_once '/helpers/scripts/directories.php';

spl_autoload_register(function ($class) {
    global $directories;
    $classDirectory = '';

    // Check each folder;
    foreach ($directories as $directory) {
        if (str_contains($class, $directory)) {
            $classDirectory = str_replace('\\', '/', strtolower($directory));
        }
    }

    // Guard clause.
    if (!$classDirectory) {
        return;
    }

    // Filter out class name.
    $namespaceParts = explode('\\', $class);
    $className = $namespaceParts[count($namespaceParts) - 1];
    $classPath = '/' . $classDirectory . '/' . $className . '.php';

    if (file_exists($classPath)) {
        require_once $classPath;
    }
});
