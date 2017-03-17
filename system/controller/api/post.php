<?php
/**
* API Controller
*/

class postAPI extends Controller
{
  function __construct() {
    parent::__construct();
  }

  function list() {
    $this->load('post/list', 'api');
  }

  function post() {
    $this->load('post/post', 'api');
  }

  function edit() {
    $this->load('post/edit', 'api');
  }

  function delete() {
    $this->load('post/delete', 'api');
  }

  function favour() {
    $this->load('post/favour', 'api');
  }

  function is_ok($action) {
    switch ($action) {
      case 'post':
      case 'edit':
      if (isset($_POST['user_id'], $_POST['title'], $_POST['content'], $_POST['img'], $_POST['type'])) {
        $_POST['user_id'] = (int)$_POST['user_id'];
        $_POST['title'] = xss_clean($_POST['title']);
        $_POST['content'] = xss_clean($_POST['content']);
        $_POST['img'] = xss_clean($_POST['img']);
        $_POST['type'] = (int)$_POST['type'];
        return true;
      }
      die($this->http->info(400));
      break;
      case 'delete':
      case 'favour':
      if (isset($_POST['user_id']) && isset($_POST['post_id'])) {
        $_POST['user_id'] = (int)$_POST['user_id'];
        $_POST['post_id'] = (int)$_POST['post_id'];
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
