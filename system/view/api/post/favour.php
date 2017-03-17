<?php
$result = $this->post->favour($_POST['user_id'], $_POST['post_id']);
switch ($result['status']) {
  case '200':
    $this->http->response(200, 'Favour Successfully', $result['content']);
  break;
  case '404':
    $this->http->response(404, 'Post Not Fount or be deleted just now');
  break;
  /* Banned Account can do favour */
  case '503':
    $this->http->response(503, 'DataBase Error');
  break;
  default:
    $this->http->response(503, 'DataBase Error');
  break;
}
?>
