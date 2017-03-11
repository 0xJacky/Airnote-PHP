<?php
if (isset($_POST['user_id'])) {
  $result = $this->user_model->logout($_POST['user_id']);
  switch ($result) {
    case '200':
    $this->http->respone(200, 'Logout Success');
    break;
    case '503':
    $this->http->respone(503, 'DataBase Error');
    break;
    default:
    $this->http->respone(503, 'DataBase Error');
    break;
  }
}
?>
