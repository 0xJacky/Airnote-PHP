<?php
$result = $this->post_model->post_list($_POST['page']);
switch ($result['status']) {
  case '200':
  $this->http->respone(200, $result['content']);
  break;
  case '503':
  $this->http->respone(503, 'DataBase Error');
  break;
  default:
  $this->http->respone(503, 'DataBase Error');
  break;
}
?>
