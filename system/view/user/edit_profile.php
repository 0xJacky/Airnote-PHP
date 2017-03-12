<?php
if (isset($_POST['id']) && isset($_POST['request']) && isset($_POST['content'])) {
    $result = $this->user->edit_profile($_POST['id'], $_POST['request'], $_POST['content']);
    switch ($result['status']) {
      case '200':
        $this->http->response(200, 'Edit Successfully', $result['content']);
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
