<?php
if (!defined("IN_JIANJI")) {
  die();
}

$result = $this->user->register($_POST['name'], $_POST['pwd'], $_POST['mail']);
switch ($result) {
  case '200':
  $this->http->response(200, 'Register Successflly', $result['token']);
  break;
  case '4051':
  $this->http->response(4051, 'You have registered');
  break;
  case '4052':
  $this->http->response(4052, 'Name Conflict');
  break;
  case '4053':
  $this->http->response(4053, 'Mail Conflict');
  break;
  case '503':
  $this->http->response(503, 'DataBase Error');
  break;
  default:
  $this->http->response(503, 'DataBase Error');
  break;

?>
