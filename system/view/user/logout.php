<?php
if (isset($_POST['user_id'])) {
  $result = $this->user->logout($_POST['user_id']);
  switch ($result) {
    case '200':
    $this->http->response(200, 'Logout Success');
    break;
    case '503':
    $this->http->response(503, 'DataBase Error');
    break;
    default:
    $this->http->response(503, 'DataBase Error');
    break;
  }
}
?>
