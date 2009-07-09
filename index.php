<?php

error_reporting(E_ALL);
ini_set('display_errors', 2);

if (!defined('LOGBOX_PATH')) {
    define('LOGBOX_PATH', dirname(__FILE__));
}

require_once LOGBOX_PATH . '/classes/Logbox.php';

spl_autoload_register(array('Logbox', 'autoload'));

set_error_handler(array('Logbox', 'errorHandler'));

date_default_timezone_set(Options::get('timezone'));

//Messages::import();

Controller::dispatchRequest();
