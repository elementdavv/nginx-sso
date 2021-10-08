<?php
declare (strict_types = 1);

namespace Lakedai\Login\Control;

require_once 'base.php';

use Lakedai\Login\Utils\Form;

class Login extends Base {

    public function loginView() {

        echo $this->twig->render('login.twig',[
            "domain_url" => $this->config['domain_url'],
            "domain_name" => $this->config['domain_name'],
	    "action" => "login?url=" . $this->url,
	    "error" => $this->error
        ]);

    }

    public function login() {

	try {
	    $email = Form::email($_POST['email']);
	    $password = Form::password($_POST['password']);
	    $this->auth->login($email, $password);
	    if (!empty($this->url)) {
		header('Location: ' . $this->url);
	    }
	    else {
		header('Location: ' . $this->config['afterlogin']);
	    }
	    return;
	}
	catch (\Delight\Auth\InvalidEmailException $e) {
	    $error = 'Wrong email address';
	}
	catch (\Delight\Auth\InvalidPasswordException $e) {
	    $error = 'Wrong password';
	}
	catch (\Delight\Auth\EmailNotVerifiedException $e) {
	    $error = 'Email not verified';
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
	    $error = 'Too many requests';
	}
	catch (\Exception $e) {
	    $error = $e->getMessage();
	}
	header('Location: login?url=' . $this->url . '&error=' . $error);

    }

    public function validate() {

	// error_log("uri:" . $_SERVER['HTTP_X_ORIGINAL_URI'] . "\n", 3, '/home/legend/tmp/log.log');
	if ($this->auth->check()) {
	    header('HTTP/1.1 200 OK');
            // follow RFC 3875	
	    header('REMOTE_USER: ' . $this->auth->getEmail());
	}
	else {
	    header('HTTP/1.1 401 Unauthorized');
	}

    }

    public function logout() {

	$this->auth->logOut();
	$this->auth->destroySession();
	if (!empty($this->url)) {
	    header('Location: ' . $this->url);
	}
	else {
	    header('Location: ' . $this->config['afterlogout']);
	}

    }

}
