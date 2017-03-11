<?php
/**
 * API User class model
 */
class user extends Model
{

  function __construct()
  {
    parent::__construct();
  }

  function register($name, $pwd, $mail) {
    $try_mail = 'SELECT `user_mail` FROM `api_users` WHERE `user_mail` = \''.$mail.'\'';
    $try_name = 'SELECT `user_name` FROM `api_users` WHERE `user_name` = \''.$name.'\'';
    $result_name = $this->db->fetch_array($try_name);
    $result_mail = $this->db->fetch_array($try_mail);
    if($result_name['user_name'] == $name && $result_mail['user_mail'] == $mail) {
      return 4051;
    }
    if ($result_name['user_name'] == $name) {
      return 4052;
    }
    if ($result_mail['user_mail'] == $mail) {
      return 4053;
    }
    $time = date("Y-m-d H:i:s", strtotime('now'));
    $sql = "INSERT INTO `api_users` (`user_name`, `user_pass`, `user_mail`, `user_status`, `user_login`, `registered_time`, `lastest_login`, `user_token`)";
    $sql .= "VALUES ('$name', '$pwd', '$mail', 1, 1, '$time', '$time', 'null')";
    $result = $this->db->query($sql);
    if ($result == false) {
      return 503;
    } else {
      return 200;
    }
  }
}
?>
