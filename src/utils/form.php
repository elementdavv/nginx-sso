<?php
declare (strict_types = 1);

namespace Elementdavv\Login\Utils;

/* validate, sanitize and return input */
class Form{

    const PASSWORD_MIN = 4;
    const PASSWORD_MAX = 12;

    public static function text($input, $title) : string {

	$input = self::check_empty($input, $title);

	$input = filter_var($input, FILTER_SANITIZE_STRING);

	return $input;

    }

    public static function email($input) : string {

	$input = self::check_empty($input, 'Email');

	$input = filter_var($input, FILTER_SANITIZE_EMAIL);

	if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
	    throw new \Exception('Invalid email');
	}

	return $input;

    }

    public static function password($input) : string {

	$input = self::check_empty($input, 'Password');

	$input = filter_var($input, FILTER_SANITIZE_STRING);

	if (strlen($input) < self::PASSWORD_MIN || strlen($input) > self::PASSWORD_MAX) {
	    throw new \Exception('Password length should be between ' . self::PASSWORD_MIN . ' and ' . self::PASSWORD_MAX);
	}
	return $input;

    }

    public static function matchPassword($input, $input2) : string {

	$input = self::check_empty($input, 'Password');
	$input2 = self::check_empty($input2, 'Password repeat');

	$input = filter_var($input, FILTER_SANITIZE_STRING);
	$input2 = filter_var($input2, FILTER_SANITIZE_STRING);

	if (strcmp($input, $input2) != 0) {
	    throw new \Exception('Passwords must match');
	}
	else if (strlen($input) < self::PASSWORD_MIN || strlen($input) > self::PASSWORD_MAX) {
	    throw new \Exception('Password length should be between ' . self::PASSWORD_MIN . ' and ' . self::PASSWORD_MAX);
	}
	return $input;

    }

    protected static function check_empty($input, $title) : string {

	$input = trim($input);

	if (empty($input)) {
	    throw new \Exception($title . ' required');
	}

	return $input;

    }

}
