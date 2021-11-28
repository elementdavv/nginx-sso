<?php
declare (strict_types = 1);

namespace Elementdavv\Login\Control;

require_once 'base.php';

use Elementdavv\Login\Utils\Form;

class Signup extends Base {

    public function signupView() {

        echo $this->twig->render('signup.twig',[
            "domain_url" => $this->config['domain_url'],
            "domain_name" => $this->config['domain_name'],
	    "action" => "signup",
	    "error" => $this->error
        ]);

    }

    public function signup() {

	try {
	    $email = Form::email($_POST['email']);
	    $password = Form::matchPassword($_POST['password'], $_POST['passwordrepeat']);

	    if ($this->config['email_activation']) {
	    	$this->auth->register($email, $password, null, function($selector, $token) use($email) {
		    $subject = "Please verify your email for Timelegend.net";
		    $message = $this->twig->render('email.twig', [
		        "email" => $email,
		        "selector" => $selector,
		        "token" => $token
		    ]);
                    $header = "MIME-Vervion: 1.0\r\n";
                    $header .= "Content-Type: text/html; charset=UTF-8\r\n";
		    mail($email, $subject, $message, $header);
	    	});

	    	$error = 'Your account has been made, please verify it by click the activation link that has been sent to your email.';
                echo $this->twig->render('after.twig',[
	            "response" => $error
	    	]);
	    }
	    else {
	    	$this->auth->register($email, $password, null, null);
	    	$error = "Sign up successful! Please login.";
	    	header('Location: login?' . 'error=' . $error);
	    }

	    return;
	}
	catch (\Delight\Auth\InvalidEmailException $e) {
	    $error = 'Invalid email address';
	}
	catch (\Delight\Auth\InvalidPasswordException $e) {
	    $error = 'Invalid password';
	}
	catch (\Delight\Auth\UserAlreadyExistsException $e) {
	    $error = 'User already exists';
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
	    $error = 'Too many requests';
	}
	catch (\Exception $e) {
	    $error = $e->getMessage();
	}
	header('Location: signup?' . 'error=' . $error);

    }

    public function verify() {

	try {
	    $selector= Form::text($_GET['selector'], 'selector');
	    $token= Form::text($_GET['token'], 'token');
	    $this->auth->confirmEmail($selector, $token);
	    $error = "Email verified successful! Please login.";
	    header('Location: login?' . 'error=' . $error);
	}
	catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
	    $error = 'Invalid token';
	}
	catch (\Delight\Auth\TokenExpiredException $e) {
	    $error = 'Token expired';
	}
	catch (\Delight\Auth\UserAlreadyExistsException $e) {
	    $error = 'Email address already exists';
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
	    $error = 'Too many requests';
	}
	catch (\Exception $e) {
	    $error = $e->getMessage();
	}
        echo $this->twig->render('after.twig',[
	    "response" => "Email verified failed: " . $error
	]);

    }

}
