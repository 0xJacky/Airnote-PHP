<?php
/* Airnote autoload Common Class Libraries */
defined('BASE_PATH') OR exit('No direct script access allowed');

require('vendor/autoload.php');

class autoload
{

    public function __construct()
    {
        $this->core();
    }

    public function core($class)
    {
        require($class);
    }
}
/* Load Configs */
require('config.php');
if (IN_DEBUG) {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}
/* Setup DB Class */
require(CORE_PATH . 'mysqli.php');

/* Setup Model Class */
require(CORE_PATH . 'model.php');

/* Setup Controller Class */
require(CORE_PATH . 'controller.php');

/* Setup HTTP Class */
require(CORE_PATH . 'http.php');

/* Load Url Class */
require(CORE_PATH . 'url.php');

/* Load Models */
require(M_PATH . 'api/user.php');
require(M_PATH . 'api/post.php');

/* Setup Auth Class */
require(CORE_PATH . 'auth.php');

/* Load helper functions */
require(CORE_PATH . 'functions.php');

/* Load Router Class */
require(CORE_PATH . 'router.php');

/* Load Controllers */
require(C_PATH . 'frontend.php');
require(C_PATH . 'admin.php');
require(C_PATH . 'user_api.php');
require(C_PATH . 'post_api.php');

$router = new Router();
$router->run();
