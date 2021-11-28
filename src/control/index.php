<?php
declare (strict_types = 1);

namespace Elementdavv\Login\Control;

require_once 'base.php';

class Index extends Base {

    public function index() {

	    if ($this->auth->check()) {
	        $email = $this->auth->getEmail();
	        $user = 'visible';
	        $nouser = 'none';
	    }
	    else {
    		$email = '';
	        $user = 'none';
	        $nouser = 'visible';
	    }

        echo $this->twig->render('index.twig',[
            "domain_url" => $this->config['domain_url'],
            "domain_name" => $this->config['domain_name'],
            "email" => $email ?: '',
	        "user" => $user,
	        "nouser" => $nouser
        ]);

    }

}
