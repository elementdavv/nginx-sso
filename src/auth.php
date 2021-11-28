<?php
declare (strict_types = 1);

namespace Elementdavv\Login;

require_once __DIR__ . '/config.php';

use Delight\Auth\Auth;

function auth() {

    $config = config();

    $db = new \PDO("mysql:dbname=" . $config['dbname'] . ";host:" . $config['dbhost'] . ";charset=utf8mb4", $config['dbuser'], $config['dbpassword']);

    return new Auth($db);

}
