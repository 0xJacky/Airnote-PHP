<?php
if (isset($_POST['user_mail'])) {
  $result = $this->user->get_info($_POST['user_mail']);
  switch ($result['status']) {
    case '200':
      $this->http->respone(200, $result['profile'], $result['token']);
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
