<?php
if(isset($_POST['register_name']) && isset($_POST['register_pw']) && isset($_POST['register_mail'])) {
  $result = $this->user_model->register($_POST['register_name']), $_POST['register_pw'], $_POST['register_mail']);
  switch ($result) {
    case '200':
    $this->http->respone(200, 'Register Success');
    break;
    case '4051':
    $this->http->respone(4051, 'You have registered');
    break;
    case '4052':
    $this->http->respone(4052, 'Name Conflict');
    break;
    case '4053':
    $this->http->respone(4053, 'Mail Conflict');
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
