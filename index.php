<?php

//Start the Session
session_start();

// Defines
$separator = (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') ? "\\" : "/";
define('DIR_SEPARATOR', $separator);
define('ROOT_DIR', realpath(dirname(__FILE__)) . DIR_SEPARATOR);
define('APP_DIR', ROOT_DIR . 'application' . DIR_SEPARATOR);

// Includes
require(APP_DIR . 'config' . DIR_SEPARATOR . 'config.php');
require(ROOT_DIR . 'system' . DIR_SEPARATOR . 'model.php');
require(ROOT_DIR . 'system' . DIR_SEPARATOR . 'view.php');
require(ROOT_DIR . 'system' . DIR_SEPARATOR . 'controller.php');
require(ROOT_DIR . 'system' . DIR_SEPARATOR . 'system.php');

// Define base URL
global $config;
define('BASE_URL', $config['baseUrl']);

// load default page
$system = new System();
$system->load();

?>
