<?php
if (isset($_POST['user_id']) && isset($_POST['post_id'])) {
  $result = $this->post->post_edit_content($_POST['user_id'], $_POST['post_id']) {
  switch ($result['status']) {
    case '200':
    $this->http->response(200, 'Delete Successfully', $result['token']);
    break;
    case '403':
    $this->http->response(403, 'Forbidden');
    break;
    case '404':
    $this->http->response(404, 'Post Not Found');
    break;
    case '407':
    $this->http->response(407, 'Account Banned');
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
