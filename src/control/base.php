<?php
declare (strict_types = 1);

namespace Elementdavv\Login\Control;

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

	$this->config = \Elementdavv\Login\config();
	$this->auth = \Elementdavv\Login\auth();
	$this->twig = \Elementdavv\Login\twig();

	if (!empty($_GET['url'])) {
	    $this->url = $_GET['url'];
	}
	if (!empty($_GET['error'])) {
	    $this->error = $_GET['error'];
	}

    }
}
