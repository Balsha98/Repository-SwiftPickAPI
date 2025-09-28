<?php

spl_autoload_register(function ($class) {
    $prefixes = ['Classes\\'];

    foreach ($prefixes as $prefix) {
        if (!str_contains($class, $prefix)) {
            return;
        }
    }

    $className = explode('\\', $class)[2];
    $classPath = __DIR__ . '\\classes\\' . $className . '.php';

    if (file_exists($classPath)) {
        require_once $classPath;
    }
});
