<?php
if (!defined("IN_JIANJI")) {
  die();
}

$result = $this->user->edit_profile($_POST['user_id'], $_POST['request'], $_POST['content']);
switch ($result['status']) {
  case '200':
    $this->http->response(200, 'Edit Successfully', $result['content']);
    break;
  case '404':
    $this->http->response(404, 'User Not Found');
    break;
  default:
    $this->http->response(404, 'User Not Found');
    break;
}
?>
