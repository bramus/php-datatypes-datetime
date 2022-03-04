<?php

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 'on');

// Config (variable)
// …

// Config (fixed)
define('OCPI_BASEURL', 'https://ocpi.myev.test/');
define('OCPI_BASEURL_MSP', 'https://ocpi.myev.test/emsp/');
define('OCPI_BASEURL_CPO', 'https://ocpi.myev.test/cpo/');

// Require Composer Autoloader
require_once(__DIR__ . '/../vendor/autoload.php');
