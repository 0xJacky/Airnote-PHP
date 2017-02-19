<?php
/**
* 笺记 API 操作结果返回公用类库
* Copyright 2017 0xJacky
**/
if ( !defined('IN_JianJi') && !defined('ROOT_PATH') ) {
  die('Boom');
}
class cls_result {

  function success()
  {
    $message['error'] = 0;
    $message['api_version'] = API_VERSION;
    $message['timestamp'] = time();

    echo json_encode($message);
  }

  function fail()
  {
    $message['error'] = 400;
    $message['api_version'] = API_VERSION;
    $message['timestamp'] = time();
    echo json_encode($message);
  }

  function db_error()
  {
    $message['error'] = 503;
    $message['timestamp'] = time();
    echo json_encode($message);
  }

  function user_info($result_array)
  {
    global $user;
    if ($user->get_info($result_array)) {
      echo json_encode($user->get_info($result_array));
    } else {
      $message['error'] = 503;
      $message['timestamp'] = time();
      echo json_encode($message);
    }
  }

  function reg_conflict($str = NULL)
  {
    $message['error'] = 405;
    if ( $str == NULL )
    {
      $message['field'] = 'ID';
    } elseif ( $str == 'name' ) {
      $message['field'] = 'name';
    } elseif ( $str == 'mail' ) {
      $message['field'] = 'mail';
    }
    $message['timestamp'] = time();
    echo json_encode($message);
  }

  function login_fail()
  {
    $message = array(
      'error' => 406,
      'time' => time()
    );
    echo json_encode($message);
  }

  function banned()
  {
    $message = array(
      'error' => 407,
      'time' => time()
    );
    echo json_encode($message);
  }

  function user_edit_info($id, $profile)
  {
    global $user;
    global $auth;
    if ( $user->edit_info($id, $profile) == 1 ) {
      $this->do_success($auth->generate_token($id));
    } else {
      $message = array(
        'error' => 503,
        'time' => time()
      );
      echo json_encode($message);
    }
  }

  function notfound()
  {
    $message = array(
      'error' => 404,
      'time' => time()
    );
    echo json_encode($message);
  }

  function post_success($id, $time, $user_token)
  {
    global $db;
    $sql = 'SELECT * FROM `api_posts` WHERE `post_author` = '.$id.' AND `post_date` = \''.$time.'\'';
    $result = $db->fetch_array($sql);
    $message = array(
      'error' => 0,
      'post_id' => $result['ID'],
      'post_date' => $result['post_date'],
      'post_date_gmt' => $result['post_date_gmt'],
      'token' => $user_token
    );
    echo json_encode($message);
  }

  function do_success($user_token)
  {
    $message = array(
      'error' => 0,
      'token' => $user_token
    );
    echo json_encode($message);
  }

  function do_reg($user_mail)
  {
    global $db;
    global $user;
    global $auth;
    $sql = 'SELECT *  FROM `api_users` WHERE `user_mail` = \''.$user_mail.'\'';
    if( $db->query($sql) == false ) {
      $this->db_error(); // 503 数据库错误
      exit();
    } else {
      $result = $db->fetch_array($sql);
      $id = $result['ID'];
      $user_token = $auth->generate_token($id);
      $sql = 'UPDATE `api_users` SET `user_token` = \''.$user_token.'\' WHERE `ID` = \''.$id.'\'';
      $add_option = $user->add_option($id, 'has_profile', 0);
      $add_option = $user->add_option($id, 'mobile', 'null');
      $add_option = $user->add_option($id, 'avatar', 'null');
      $add_option = $user->add_option($id, 'birthday', 'null');
      $add_option = $user->add_option($id, 'gender', 'null');
      $add_option = $user->add_option($id, 'province', 'null');
      $add_option = $user->add_option($id, 'area', 'null');
      $add_option = $user->add_option($id, 'introduction', 'null');
      if( $db->query($sql) == false && $add_option == false ) {
        $this->db_error(); // 503 数据库错误
        exit();
      } else {
        $message = array(
          'error' => 0,
          'registered_id' => $id,
          'token' => $user_token
        );
        echo json_encode($message);
      }
    }
  }

  function forbidden()
  {
    $message = array(
      'error' => 403,
      'time' => time()
    );
    echo json_encode($message);
  }

  function all_post_list()
  {
    global $db;
    $array = $db->fetch_all('SELECT `ID`, `post_author`, `post_title`, `post_img`, `favour` FROM `api_posts` ORDER BY `api_posts`.`post_date` DESC');
    $message = array(
      'error' => 0,
      'post_list' => $array,
      'timestamp' => time(),
    );
    echo json_encode($message);
  }

  function upload_avatar($id, $img)
  {
    global $user;
    global $auth;
    if ($user->upload_avatar($id, $img) == 1) {
      $this->do_success($auth->generate_token($id));
    }
  }

  function do_favour($user_id, $post_id)
  {
    global $post;
    global $auth;
    if ($post->do_favour($user_id, $post_id) == 1) {
      $this->do_success($auth->generate_token($id));
    //} else {
    //  $this->fail();
    }
  }
}
?>
