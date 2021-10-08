<?php
declare (strict_types = 1);

namespace Lakedai\Login;

require_once 'control/index.php';
require_once 'control/signup.php';
require_once 'control/login.php';
require_once 'control/reset.php';

use \Bramus\Router\Router;

class Routes {

    private $router;

    public function __construct() {

	$this->router = new Router();
	$this->router->setNamespace('\Lakedai\Login\Control');

	$this->router->get('/about', function() {
	    echo 'about ';
	});

	// home
	$this->router->get('/', 'Index@index');

	// register
	$this->router->get('/signup', 'Signup@signupView');
	$this->router->post('/signup', 'Signup@signup');
	$this->router->get('/verify', 'Signup@verify');

	// login
	$this->router->get('/login', 'Login@loginView');
	$this->router->post('/login', 'Login@login');
	$this->router->get('/validate', 'Login@validate');
	$this->router->get('/logout', 'Login@logout');

	// forgot password
	$this->router->get('/forgot', 'Reset@forgotView');
	$this->router->post('/forgot', 'Reset@forgot');
	$this->router->get('/reset', 'Reset@resetView');
	$this->router->post('/reset', 'Reset@reset');

    }

    public function run() {

	$this->router->run();

    }
}
