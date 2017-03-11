<?php
if (!defined("IN_JIANJI")) {
  die();
}

require('init.php');

if (isset($_POST['method'])) {
  $method = $_POST['method'];
    if (method_exists($api, $method)) {
      $api->$method();
    } else {
      $http->info(405);
    }
} else {
  $http->info(400);
}
?>
