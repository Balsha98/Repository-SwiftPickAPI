<?php

namespace Source\Handlers\Autoload;

class Autoloader
{
    private static const array DIRECTORIES = require_once __DIR__ . '/helpers/scripts/directories.php';

    public static function autoload() {
        spl_autoload_register(function ($class) {
            $classDirectory = '';

            // Check each folder;
            foreach (self::DIRECTORIES as $directory) {
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
            $classPath = __DIR__ . '/' . $classDirectory . '/' . $className . '.php';

            if (file_exists($classPath)) {
                require_once $classPath;
            }
        });
    }
}

