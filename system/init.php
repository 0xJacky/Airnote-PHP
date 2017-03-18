<?php
/* JianJi AutoLoad Common Class Libraries */
if (!defined("IN_JIANJI")) {
  die();
}
ini_set('date.timezone','Asia/Shanghai');
/* SYSTEM Root Path */
define('ROOT_PATH', dirname(__FILE__));
/* JianJi Libraries Path */
define('CLASS_PATH', ROOT_PATH . '/includes/');
/* JianJi Model Path*/
define('M_PATH', ROOT_PATH . '/model/');
/* JianJi View Path */
define('V_PATH', ROOT_PATH . '/view/');
/* JianJi Controller Path */
define('C_PATH', ROOT_PATH . '/controller/');
/* Website Root Path */
define('BASEPATH', dirname(ROOT_PATH) . '/');

/* base url define */
$sitepath = dirname(dirname($_SERVER['PHP_SELF']));
$sitepath = strlen($sitepath) === 1 ? '/' : $sitepath.'/';
$siteurl = htmlspecialchars(($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath);
define('SITE_URL', $siteurl);

/* Load Configs */
require('config.php');

/* Setup DB Class */
require(CLASS_PATH . 'mysqli.php');

/* Setup Model Class */
require(CLASS_PATH . 'model.php');

/* Setup Controller Class */
require(CLASS_PATH . 'controller.php');

/* Setup HTTP Class */
require(CLASS_PATH . 'http.php');
$http = new http();

/* Load Models */
require(M_PATH.'api/user.php');
require(M_PATH.'api/post.php');

/* Setup Auth Class */
require(CLASS_PATH . 'auth.php');
$auth = new auth();

/* Load Controllers */
require(C_PATH.'api/user.php');
require(C_PATH.'api/post.php');
$userAPI = new userAPI();
$postAPI = new postAPI();

/* Load helper functions */
require(CLASS_PATH . 'functions.php');
?>
