<?php
if (isset($_POST['id']) && isset($_POST['profile'])) {
    $result = $this->user->user_edit_info($id, $profile);
    switch ($result['status']) {
      case '200':
        $this->http->response(200, 'Edit Successfully', $result['token']);
        break;
      case '404':
        $this->http->response(404, 'User Not Found');
        break;
      default:
        $this->http->response(404, 'User Not Found');
        break;
    }
}
?>
