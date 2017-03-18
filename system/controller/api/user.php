<?php
/**
 * API Controller
**/
if (!defined("IN_JIANJI")) {
  die();
}

class userAPI extends Controller
{
  function __construct() {
    parent::__construct();
  }

  function login() {
    if ($this->is_ok('login'))
      $this->load('user/login', 'api');
  }

  function logout() {
    if ($this->is_ok('login'))
      $this->load('user/logout', 'api');
  }

  function register() {
    if ($this->is_ok('login'))
      $this->load('user/register', 'api');
  }

  function info() {
    if ($this->is_ok('login'))
      $this->load('user/info', 'api');
  }

  function edit_profile() {
    if ($this->is_ok('login'))
      $this->load('user/edit_profile', 'api');
  }

  function is_ok($action) {
    switch ($action) {
      case 'login':
          if (isset($_POST['mail'], $_POST['pwd'])) {
            $_POST['mail'] = xss_clean($_POST['mail']);
            $_POST['pwd'] = xss_clean($_POST['pwd']);
            return true;
          }
          die($this->http->info(400));
        break;
      case 'logout':
          $_POST['user_id'] = (int)$_POST['user_id']; // It has been check in security.php
          return true;
        break;
      case 'register':
          if(isset($_POST['name'], $_POST['pwd'], $_POST['mail'])) {
            $_POST['name'] = xss_clean($_POST['name']);
            $_POST['pwd'] = xss_clean($_POST['pwd']);
            $_POST['mail'] = xss_clean($_POST['mail']);
            return true;
          }
          die($this->http->info(400));
        break;
      case 'info':
          if (isset($_POST['mail'])) {
            $_POST['mail'] = xss_clean($_POST['mail']);
            return true;
          }
          die($this->http->info(400));
        break;
      case 'edit_profile':
          if (isset($_POST['request'], $_POST['content'])) {
            $_POST['user_id'] = (int)$_POST['user_id']; // It has been check in security.php
            $_POST['request'] = xss_clean($_POST['request']);
            $_POST['content'] = xss_clean($_POST['content']);
            return true;
          }
          die($this->http->info(400));
        break;

      default:
        die($this->http->info(400));
        break;
    }
  }
}


?>
