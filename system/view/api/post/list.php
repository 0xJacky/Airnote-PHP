<?php
if (!defined("IN_JIANJI")) {
  die();
}

$page = (int)$_POST['page'] ? $_POST['page'] : 1;
$result = $this->post->list($page);
switch ($result['status']) {
  case '200':
  $this->http->response(200, 'Geted the page '.$page, $result['content']);
  break;
  case '503':
  $this->http->response(503, 'DataBase Error');
  break;
  default:
  $this->http->response(503, 'DataBase Error');
  break;
}
?>
