<?php
$result = $this->user->get_info($_POST['mail']);
switch ($result['status']) {
  case '200':
    $this->http->response(200, 'User info get successfully', $result['content']);
    break;
  case '404':
    $this->http->response(404, 'User Not Found');
    break;
  default:
    $this->http->response(404, 'User Not Found');
    break;
}

?>
