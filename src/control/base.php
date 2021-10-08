<?php
declare (strict_types = 1);

namespace Lakedai\Login\Control;

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../auth.php'; 
require_once __DIR__ . '/../twig.php';
require_once __DIR__ . '/../utils/form.php';

class Base{

    public $config = null;
    public $auth = null;
    public $twig = null;
    public $url = '';
    public $error = '';

    public function __construct() {
	
	$this->config = \Lakedai\Login\config();
	$this->auth = \Lakedai\Login\auth();
	$this->twig = \Lakedai\Login\twig();

	if (!empty($_GET['url'])) {
	    $this->url = $_GET['url'];
	}
	if (!empty($_GET['error'])) {
	    $this->error = $_GET['error'];
	}

    }
}
