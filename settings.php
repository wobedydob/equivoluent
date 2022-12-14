<?php

//region PHP
if(PHP_VERSION < '8.0'){
    $error = new \Error('Equivoluent does not support PHP version: ' . PHP_VERSION);
    echo '<h1>' . $error->getMessage() . '</h1>';
    echo '<strong>' . $error->getFile() . '</strong> on line: ' . $error->getLine();
    exit();
}
//endregion

//region Config
if (!file_exists(__DIR__ . '/config.php')) {
    echo '<h1> Config file not found!</h1>';
    exit();
}
require __DIR__ . '/config.php';

define('SITE_URL', $site_url);

//region Database
define('DB_HOST', $db_host);
define('DB_NAME', $db_name);
define('DB_USERNAME', $db_user);
define('DB_PASSWORD', $db_password);

// default port
define('DB_PORT', 3306);

// default charset
define('DB_CHAR', 'utf8');
//endregion

//region ERRORS AFTER SETUP
if ($display_errors) {
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
}
//endregion

//endregion