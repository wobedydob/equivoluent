<?php

function include_php_files(string $folder): void
{
    $folder = __DIR__ . DIRECTORY_SEPARATOR . $folder;

    foreach (glob("{$folder}/*.php") as $filename) {
        include_once $filename;
    }
}

include_php_files('classes');
include_php_files('methods');