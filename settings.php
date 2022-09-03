<?php

//region CONFIG
if (!file_exists(__DIR__ . '/config.php')) {
    echo '<h1> Config file not found!</h1>';
    exit();
}
require __DIR__ . '/config.php';

define('SITE_URL', $site_url);

//region DATABASE
define('DB_HOST', $db_host);
define('DB_NAME', $db_name);
define('DB_USERNAME', $db_user);
define('DB_PASSWORD', $db_password);
//endregion

//region ERRORS AFTER SETUP
if ($display_errors) {
    ini_set('display_startup_errors', 1);
    ini_set('display_errors', 1);
    error_reporting(-1);
}
//endregion

//endregion