<?php
if (!defined("IN_JIANJI")) {
  die();
}

require('init.php');

if ($_POST == NULL) {
  exit($http->info(200));
} else {
  if (!isset($_POST['auth_key'])) {
    die($http->info(403));
  }
  if (!$auth->check_auth_key($_POST['auth_key'])) {
    die($http->info(403));
  }
  $t = array('logout', 'info', 'edit_profile', 'post', 'edit', 'delete', 'favour');
  if (!isset($_POST['action'])) {
    die($http->info(400));
  }
  if (in_array($_POST['action'], $t)) {
    if (!isset($_POST['user_id'], $_POST['token'])) {
      die($http->info(403));
    }
    if (!$auth->check_token($_POST['user_id'], $_POST['token'])) {
      die($http->info(403));
    }
  }
}
?>
