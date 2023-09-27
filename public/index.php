<?php

require_once(dirname(__FILE__, 2) . '/src/config/config.php');

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

if($uri == "/index.php" || $uri == '/'){
    $uri = '/day_records.php';
}

require_once(CONTROLLER_PATH . "$uri");