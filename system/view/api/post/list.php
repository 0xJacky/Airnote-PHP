<?php
$page = (int)$_POST['page'] ? $_POST['page'] : 1;
$result = $this->post->post_list($page);
switch ($result['status']) {
  case '200':
  $this->http->response(200, $result['content']);
  break;
  case '503':
  $this->http->response(503, 'DataBase Error');
  break;
  default:
  $this->http->response(503, 'DataBase Error');
  break;
}
?>
