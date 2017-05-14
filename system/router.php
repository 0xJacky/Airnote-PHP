<?php
/*if (!defined("IN_JIANJI")) {
  die();
}

if (isset($_POST['method'], $_POST['action'])) {
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
  $http->info(400);
}
?>
