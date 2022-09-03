<?php

spl_autoload_register(function (string $class): bool {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';

    if (!file_exists($file)) {
        return false;
    }

    include $file;
    return true;

});