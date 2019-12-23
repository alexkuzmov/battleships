<?php

// Server configuration
set_time_limit(0);
date_default_timezone_set('UTC');
error_reporting(E_ALL);

ini_set('display_errors', 1);
ini_set('memory_limit', '1024M');

// The true ROOT_PATH is one folder up
define('ROOT_PATH', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

// Start sessions if they are not started yet
if (!session_id()){
	session_start();
}

function __autoload($class){
    $parts = explode('\\', $class);
	
    require ROOT_PATH . implode(DIRECTORY_SEPARATOR, $parts) . '.php';
}

// Load the core files
require_once ROOT_PATH . 'core/App.class.php';
require_once ROOT_PATH . 'core/Loader.class.php';

$loader = new Loader();

$app = new App();
$app->loader($loader);
$app->run();