<?php
if (!defined("IN_JIANJI")) {
  die();
}

$result = $this->post->post($_POST['user_id'], $_POST['title'], $_POST['content'], $_POST['img'], $_POST['type']);
switch ($result['status']) {
  case '200':
  $this->http->response(200, 'Post Successfully', $result['content']);
  break;
  case '407':
  $this->http->response(407, 'Account Banned');
  break;
  case '503':
  $this->http->response(503, 'DataBase Error');
  break;
  default:
  $this->http->response(503, 'DataBase Error');
  break;
}
?>
