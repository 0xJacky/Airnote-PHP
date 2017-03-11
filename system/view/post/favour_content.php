<?php
if (isset($_POST['user_id']) && isset($_POST['post_id'])) {
  $result = $this->post_model->favour_content($user_id, $post_id);
  switch ($result['status']) {
    case '200':
    $this->http->response(200, 'Favour Successfully', $result['token']);
    break;
    /* Banned Account can do favour 233 */
    case '503':
    $this->http->response(503, 'DataBase Error');
    break;
    default:
    $this->http->response(503, 'DataBase Error');
    break;
  }
}
?>
