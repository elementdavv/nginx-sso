<?php
declare (strict_types = 1);

namespace Elementdavv\Login\Control;

require_once 'base.php';

use Elementdavv\Login\Utils\Form;

class Reset extends Base {

    public function forgotView() {

        echo $this->twig->render('forgot.twig',[
            "domain_url" => $this->config['domain_url'],
            "domain_name" => $this->config['domain_name'],
	    "action" => "forgot",
	    "error" => $this->error
        ]);

    }

    public function forgot() {

	try {
	    $email = Form::email($_POST['email']);
	    $this->auth->forgotPassword($email, function ($selector, $token) use($email) {
	        $subject = "Password reset on Timelegend.net";
	        $message = $this->twig->render('verify.twig', [
	   	    "email" => $email,
	   	    "selector" => $selector,
	   	    "token" => $token
	        ]);
                $header = "MIME-Vervion: 1.0\r\n";
                $header .= "Content-Type: text/html; charset=UTF-8\r\n";
		mail($email, $subject, $message, $header);
	    });

            $error = "Password reset link has been sent to your email. Please click it to continue.";
            echo $this->twig->render('after.twig',[
	    	"response" => $error
	    ]);

            return;
	}
	catch (\Delight\Auth\InvalidEmailException $e) {
	    $error = 'Invalid email address';
	}
	catch (\Delight\Auth\EmailNotVerifiedException $e) {
	    $error = 'Email not verified';
	}
	catch (\Delight\Auth\ResetDisabledException $e) {
	    $error = 'Password reset is disabled';
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
	    $error = 'Too many requests';
	}
	catch (\Exception $e) {
	    $error = $e->getMessage();
	}
	header('Location: forgot?&error=' . $error);

    }

    public function resetView() {

	try {
	    $selector= Form::text($_GET['selector'], 'selector');
	    $token= Form::text($_GET['token'], 'token');
	    $this->auth->canResetPasswordOrThrow($selector, $token);
            if ($this->error == '') {
                $this->error = 'Please enter new passwords';
            }

            echo $this->twig->render('reset.twig',[
                "domain_url" => $this->config['domain_url'],
                "domain_name" => $this->config['domain_name'],
	        "action" => "reset?selector=" . $selector . '&token=' . $token,
	        "error" => $this->error
            ]);

            return;
	}
	catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
	    $error = 'Invalid token';
	}
	catch (\Delight\Auth\TokenExpiredException $e) {
	    $error = 'Token expired';
	}
	catch (\Delight\Auth\ResetDisabledException $e) {
	    $error = 'Password reset is disabled';
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
	    $error = 'Too many requests';
	}
	catch (\Exception $e) {
	    $error = $e->getMessage();
	}
        echo $this->twig->render('after.twig',[
	    "response" => $error
	]);

    }

    public function reset() {

	try {
	    $selector= Form::text($_GET['selector'], 'selector');
	    $token= Form::text($_GET['token'], 'token');
	    $password = Form::matchPassword($_POST['password'], $_POST['passwordrepeat']);
	    $this->auth->resetPassword($selector, $token, $password);
	    $error = "Password reset successful! Please login.";
	    header('Location: login?' . 'error=' . $error);

	    return;
	}
	catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
	    $error = 'Invalid token';
	}
	catch (\Delight\Auth\TokenExpiredException $e) {
	    $error = 'Token expired';
	}
	catch (\Delight\Auth\ResetDisabledException $e) {
	    $error = 'Password reset is disabled';
	}
	catch (\Delight\Auth\InvalidPasswordException $e) {
	    $error = 'Invalid password';
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
	    $error = 'Too many requests';
	}
	catch (\Exception $e) {
	    $error = $e->getMessage();
	}
	header('Location: reset?selector=' . $_GET['selector'] . '&token=' . $_GET['token'] . '&error=' . $error);

    }

}
