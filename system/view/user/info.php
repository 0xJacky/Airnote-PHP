<?php
if (isset($_POST['user_mail'])) {
  $result['status'] = $this->user_model->get_info($_POST['user_mail']);
  switch ($result) {
    case '200':
      $this->http->respone(200, $result['profile']);
      break;
    case '404':
      $this->http->respone(404, 'User Not Found');
      break;
    default:
      $this->http->respone(404, 'User Not Found');
      break;
  }
}
?>
