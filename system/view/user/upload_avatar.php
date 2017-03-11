<?php
if (isset($_POST['user_id']) && isset($_POST['img'])) {
    $result = $this->user->upload_avatar($id, $img);
    switch ($result['status']) {
      case '200':
        $this->http->respone(200, 'Upload Successfully', $result['token']);
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
