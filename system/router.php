<?php
if (!defined("IN_JIANJI")) {
  die();
}

require('init.php');

if (isset($_POST['method']) && isset($_POST['action'])) {
  $action = $_POST['action'];
  switch ($_POST['method']) {
    case 'user':
      if (method_exists($userAPI, $action)) {
        $userAPI->$action();
      } else {
        $http->info(405);
      }
      break;

    case 'post':
      if (method_exists($postAPI, $action)) {
        $postAPI->$action();
      } else {
        $http->info(405);
      }
      break;

    default:
      $http->info(405);
      break;
  }
} else {
  if ($_POST == NULL) {
    $http->info(200);
    exit();
  }
  $http->info(400);
}
?>
