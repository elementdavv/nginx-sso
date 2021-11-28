<?php
declare (strict_types = 1);

namespace Elementdavv\Login;

require_once __DIR__ . '/config.php';

session_set_cookie_params(0, '/', config()['cookie_domain']);
