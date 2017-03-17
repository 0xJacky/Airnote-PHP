<?php
if (!defined("IN_JIANJI")) {
  die();
}

$result = $this->user->login($_POST['mail'], $_POST['pwd']);
switch ($result['status']) {
  case '200':
  $this->http->response(200, 'Login Successfully', $result['content']);
  break;
  case '406':
  $this->http->response(406, 'Account Not Found & Wrong Password');
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
