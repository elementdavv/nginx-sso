<?php
declare (strict_types = 1);

namespace Lakedai\Login;

function config() {

    // cookie domain
    $config['cookie_domain'] = 'timelegend.net';

    // domain link used in sso ui
    $config['domain_url'] = 'https://timelegend.net';
    $config['domain_name'] = 'Timelegend.net';

    // redirect to after login/logout as default
    $config['afterlogin'] = 'https://timelegend.net';
    $config['afterlogout'] = 'https://timelegend.net';

    // db setup
    $config['dbhost'] = 'localhost';
    $config['dbname'] = 'phpauth';
    $config['dbuser'] = 'phpauth';
    $config['dbpassword'] = '1234';

    // if false, user will be active immediately after signing up
    $config['email_activation'] = true;

    return $config;

}
