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
    $sql = "INSERT INTO `api_users` (`name`, `sha1_pwd`, `mail`, `status`, `is_login`, `registered_time`, `lastest_active`, `token`, `avatar`, `favour`)";
    $sql .= "VALUES ('$name', '$pwd', '$mail', 1, 1, '$time', '$time', 'null', 'null', 0)";
    $result = $this->db->query($sql);
    if ($result == false) {
      return 503;
    } else {
      return 200;
    }
  }

  function login($mail, $pwd) {
    $try = 'SELECT `ID`, `sha1_pwd`, `mail`, `status` FROM `api_users` WHERE `mail` = \''.$mail.'\'';
    $result = $this->db->fetch_array($try);
    $token = $this->auth->generate_token($result['ID']);
    $time = date("Y-m-d H:i:s", strtotime('now'));
    if (empty($result) || $pwd !== $result['sha1_pwd']) {
      $result['status'] = 406;
      return $result;
    } elseif ($result['status'] == 0) {
      $result['status'] = 407;
      return $result;
    } elseif ($pwd == $result['sha1_pwd']) {
      $sql = 'UPDATE `api_users` SET `is_login` = \'1\', `lastest_active` = \''.$time.'\', `token` = \''.$token.'\' WHERE `mail` = \''.$mail.'\'';
      if( $this->db->query($sql) == false ) {
        $result['status'] = 503;
        return $result;
      } else {
        $result = array(
          'status' => 200,
          'content' => array(
            'ID' => $result['ID'],
            'token' => $token
          ),
        );
        return $result;
      }
    }

  }
}
?>
