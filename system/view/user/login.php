<?php
if (isset($_POST['user_mail']) && isset($_POST['login_pw'])) {
  $result = $this->user->login($_POST['user_mail'], $_POST['login_pw']);
  switch ($result['status']) {
    case '200':
    $this->http->respone(200, 'Login Successfully', $result['token']);
    break;
    case '406':
    $this->http->respone(406, 'Account Not Found & Wrong Password');
    break;
    case '407':
    $this->http->respone(407, 'Account Banned');
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
