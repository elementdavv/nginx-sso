<?php
declare (strict_types = 1);

namespace Elementdavv\Login;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

function twig(){

    $loader = new FilesystemLoader('../view');
    return new Environment($loader, [
	'cache' => '../cache',
    ]);

}
