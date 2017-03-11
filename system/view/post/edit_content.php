<?php
if (isset($_POST['user_id']) && isset($_POST['post_id']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['type'])) {
  $result = $this->post_model->post_edit_content($_POST['user_id'], $_POST['title'], $_POST['content'], $_POST['post_img'], $_POST['type']) {
  switch ($result['status']) {
    case '200':
    $this->http->response(200, 'Edit Successfully', $result['token']);
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
