<?php
declare (strict_types = 1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/initialize.php';

use Lakedai\Login\routes;

$routes = new Routes();
$routes->run();
