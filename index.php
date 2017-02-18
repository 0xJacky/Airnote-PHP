<?php
define('IN_JianJi', true);
require('./includes/init.php');
header("Content-type: application/json");
/**
* API 请求类型
* 1.测试类: 通讯检查
* 2.用户类：注册、登录、注销、用户信息获取、用户信息修改、上传用户头像
* 3.文章类：发布文章、编辑文章、删除文章、首页获取文章信息、点赞
**/

$get_num = count($_POST);
if ( $get_num == 2 ) {
  if ( isset($_POST['ping']) && isset($_POST['auth_key'])) //通信测试
  {

    if($auth->check_auth_key($_POST['auth_key']))
    {
      $result->success();
      exit();
    }
  } elseif (isset($_POST['action']) && isset($_POST['auth_key'])) { //首页获取文章信息
    if($_POST['action'] == 'query_post_list') {
      $result->all_post_list();
      exit();
    }
  }
} elseif ($get_num == 4 ) {
  // 用户注销
  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'user_logout') {
      if (isset(($_POST['user_id'])) && isset(($_POST['auth_key'])) && isset(($_POST['user_token']))) {
        if ($auth->check_token($_POST['user_token']) && $auth->check_auth_key($_POST['auth_key'])) {
          $id = htmlspecialchars($_POST['user_id']);
          $time = date("Y-m-d H:i:s", strtotime('now'));
          $sql = 'SELECT *  FROM `api_users` WHERE `ID` = \''.$id.'\'';
          $result_sql = $db->fetch_array($sql);
          if( $id == $result_sql['ID'] )  {
            $sql = 'UPDATE `api_users` SET `user_login` = \'0\', `lastest_login` = \''.$time.'\', `user_token` = \'NULL\' WHERE `ID` = \''.$id.'\'';
            if( $db->query($sql) == false ) {
              $result->db_error(); // 503 数据库错误
              exit();
            } else {
              $result->success();
              exit();
            }
          }
        }
      }
    } elseif ($_POST['action'] == 'user_login') {
      if (isset($_POST['user_mail']) && isset($_POST['login_pw']) && isset($_POST['auth_key'])) {
        if ($auth->check_auth_key($_POST['auth_key'])) {
          $mail = htmlspecialchars($_POST['user_mail']);
          $pw = htmlspecialchars($_POST['login_pw']);
          $time = date("Y-m-d H:i:s", strtotime('now'));
          $user_token = $auth->generate_token($id);
          $sql_mail_try = 'SELECT *  FROM `api_users` WHERE `user_mail` = \''.$mail.'\'';
          $result_mail = $db->fetch_array($sql_mail_try);
          if (empty($result_mail) || $pw !== $result_mail['user_pass']) {
            $result->login_fail(); // 406 认证失败 Account Not Found & Wrong Password
            exit();
          } elseif( $result_mail['user_status'] == 0 ) {
            $result->banned(); // 407 账户被禁用
            exit();
          } elseif( $pw == $result_mail['user_pass'] )  {
            $sql = 'UPDATE `api_users` SET `user_login` = \'1\', `lastest_login` = \''.$time.'\', `user_token` = \''.$user_token.'\' WHERE `user_mail` = \''.$mail.'\'';
            if( $db->query($sql) == false ) {
              $result->db_error(); // 503 数据库错误
              exit();
            } else {
              $message = array(
                'error' => 0,
                'user_id' => $result_mail['ID'],
                'user_token' => $user_token
              ); // 登录成功
              echo json_encode($message);
              exit();
            }
          }
        }
      }
    } elseif ($_POST['action'] == 'user_info') { // 获取用户信息
      if (isset(($_POST['user_mail'])) && isset(($_POST['auth_key'])) && isset(($_POST['user_token']))) {
        if ($auth->check_token($_POST['user_token']) && $auth->check_auth_key($_POST['auth_key'])) {
          $mail = htmlspecialchars($_POST['user_mail']);
          $time = date("Y-m-d H:i:s", strtotime('now'));
          $sql = 'SELECT *  FROM `api_users` WHERE `user_mail` = \''.$mail.'\'';
          $result_array = $db->fetch_array($sql);
          if( !empty($result_array) )  {
            $result->user_info($result_array);
            exit();
          } else {
            $result->notfound(); // 404 未找到该用户
            exit();
          }
        }
      }
    }
  }
} elseif ( $get_num == 5 ) {
  // 用户注册
  if (isset($_POST['action'])) {
    if ($_POST['action'] == 'user_register') {
      if(isset($_POST['register_name']) && isset(($_POST['register_pw'])) && isset(($_POST['register_mail'])) && isset(($_POST['auth_key']))) {
        if ($auth->check_auth_key($_POST['auth_key'])) {
          $name = htmlspecialchars($_POST['register_name']);
          $pw = htmlspecialchars($_POST['register_pw']);
          $mail = htmlspecialchars($_POST['register_mail']);
          $time = date("Y-m-d H:i:s", strtotime('now'));
          $sql_try_name  = 'SELECT *  FROM `api_users` WHERE `user_name` = \''.$name.'\'';
          $sql_try_mail  = 'SELECT *  FROM `api_users` WHERE `user_mail` = \''.$mail.'\'';
          $result_name = $db->fetch_array($sql_try_name);
          $result_mail = $db->fetch_array($sql_try_mail);
          if (empty($result_name) && empty($result_mail)) {
            $sql = "INSERT INTO `api_users` (`user_name`, `user_pass`, `user_displayname`, `user_mail`, `user_status`, `user_login`, `registered_time`, `lastest_login`, `user_token`) VALUES ('$name', '$pw', '$name', '$mail', '1', '1', '$time', '$time', 'NULL');";
            if( $db->query($sql) == false ) {
              $result->db_error(); // 503 数据库错误
              exit();
            } else {
              $result->do_reg($mail); // 执行注册后续部分
              exit();
            }
          } else {
            if ( $result_name && $result_mail ) {
              $result->reg_conflict(); // 您已注册
              exit();
            } elseif ( $result_name ) {
              $result->reg_conflict('name'); // 用户名冲突
              exit();
            } elseif ( $result_mail ) {
              $result->reg_conflict('mail'); // 邮箱冲突
              exit();
            }
          }
        }
      }
    }  elseif ($_POST['action'] == 'user_edit_profile') { // 用户信息修改
      if (isset($_POST['id']) && isset($_POST['profile']) && isset($_POST['auth_key']) && isset($_POST['user_token'])) {
        if ($auth->check_token($_POST['user_token']) && $auth->check_auth_key($_POST['auth_key'])) {
          $id = htmlspecialchars($_POST['id']);
          $profile = json_decode($_POST['profile']);
          $sql = 'SELECT `ID`  FROM `api_users` WHERE `ID` = \''.$id.'\'';
          $query_result = $db->fetch_array($sql);
          if( $id == $query_result['ID'] )  {
            $result->user_edit_info($id, $profile);
            exit();
          } else {
            $result->notfound(); // 找不到该用户
            exit();
          }
        }
      }
    } elseif ($_POST['action'] == 'delete_post') { // 删除文章
      if (isset($_POST['user_id']) && isset($_POST['post_id']) && isset(($_POST['auth_key'])) && isset(($_POST['user_token']))) {
        if ($auth->check_token($_POST['user_token']) && $auth->check_auth_key($_POST['auth_key'])) {
          $sql = 'SELECT *  FROM `api_posts` WHERE `ID` = \''.$_POST['post_id'].'\'';
          if ( $db->query($sql) == false ) {
            $result->db_error(); // 503 数据库错误
            exit();
          }
          $result_array = $db->fetch_array($sql);
          if (empty($result_array)) {
            $result->notfound(); // 404 文章未找到
            exit();
          }
          if ($result_array['post_author'] !== $_POST['user_id']) {
            $result->forbidden(); // 403 Forbidden 无权编辑他人的文章
            exit();
          }
          $post_id = htmlspecialchars($_POST['post_id']);
          $user_token = $auth->generate_token($_POST['user_id']);
          $sql = 'DELETE FROM `api_posts` WHERE `ID` = \''.$post_id.'\'';
          if ( $db->query($sql) == false ){
            $result->db_error();
            exit();
          } else {
            $result->do_success($user_token);
            exit();
          }
        }
      }
    } elseif ($_POST['action'] == 'upload_avatar') { //上传头像
      if (isset($_POST['user_id']) && isset($_POST['img']) && isset($_POST['auth_key']) && isset($_POST['user_token'])) {
        if ($auth->check_token($_POST['user_token']) && $auth->check_auth_key($_POST['auth_key'])) {
          $id = htmlspecialchars($_POST['user_id']);
          $img = htmlspecialchars($_POST['img']);
          $result->upload_avatar($id, $img);
          exit;
        }
      }
    } elseif ($_POST['action'] == 'favour') { //点赞
      if (isset($_POST['user_id']) && isset($_POST['post_id']) && isset($_POST['auth_key']) && isset($_POST['user_token'])) {
        if ($auth->check_token($_POST['user_token']) && $auth->check_auth_key($_POST['auth_key'])) {
          $user_id = htmlspecialchars($_POST['user_id']);
          $post_id = htmlspecialchars($_POST['post_id']);
          $result->do_favour($user_id, $post_id);
          exit;
        }
      }
    }
  }
} elseif ( $get_num == 8 ) {
  if ($_POST['action'] == 'post_content') {
    if (isset($_POST['user_id']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['post_img']) && isset($_POST['type']) && isset($_POST['auth_key']) && isset($_POST['user_token'])) {
      if (/*$auth->check_token($_POST['user_token']) && */$auth->check_auth_key($_POST['auth_key'])) {
        $id = htmlspecialchars($_POST['user_id']);
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $time = date("Y-m-d H:i:s", strtotime('now'));
        $gmt = date("Y-m-d H:i:s", strtotime('-8 hours'));
        $post_img = htmlspecialchars($_POST['post_img']);
        $type = htmlspecialchars($_POST['type']);
        $sql = "INSERT INTO `api_posts` (`post_author`, `post_date`, `post_date_gmt`, `post_title`, `post_content`, `post_img`, `favour`, `post_status`, `post_password`, `post_edited`, `post_edited_gmt`, `post_type`) ";
        $sql .= "VALUES ('$id', '$time', '$gmt', '$title', '$content', '$post_img', '0', '1', 'NULL', '$time', '$gmt', '$type');";
        if( $db->query($sql) == false ) {
          $result->db_error(); // 503 数据库错误
          exit();
        } else {
          $user_token = $auth->generate_token($id);
          $result->post_success($id, $time, $user_token); // 发布文章成功
          exit();
        }
      }
    }
  }
} elseif ( $get_num == 9 ) {
  if ($_POST['action'] == 'post_edit_content') {
    if (isset($_POST['user_id']) && isset($_POST['post_id']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['type']) && isset($_POST['auth_key']) && isset($_POST['user_token'])) {
      if ($auth->check_token($_POST['user_token']) && $auth->check_auth_key($_POST['auth_key'])) {
        $post_id = htmlspecialchars($_POST['post_id']);
        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $type = htmlspecialchars($_POST['type']);
        $time = date("Y-m-d H:i:s", strtotime('now'));
        $gmt = date("Y-m-d H:i:s", strtotime('-8 hours'));
        $type = htmlspecialchars(($_POST['type']));
        $sql = 'SELECT *  FROM `api_posts` WHERE `ID` = \''.$post_id.'\'';
        if ( $db->query($sql) == false ) {
          $result->db_error(); // 503 数据库错误
          exit();
        }
        $result_array = $db->fetch_array($sql);
        if ($result_array['post_author'] !== $_POST['user_id']) {
          $result->forbidden(); // 403 Forbidden 无权编辑他人的文章
          exit();
        }
        if (empty($result_array)) {
          $result->notfound(); // 404 文章未找到
          exit();
        }
        $sql = 'UPDATE `api_posts` SET `post_title` = \''.$title.'\',';
        $sql .= ' `post_content` = \''.$content.'\', `post_edited` = \''.$time.'\', `post_edited_gmt` = \''.$gmt.'\',';
        $sql .= ' `post_type` = \''.$type.'\' WHERE `ID` = '.$post_id;
        if( $db->query($sql) == false ) {
          $result->db_error(); // 503 数据库错误
          exit();
        } else {
          $result->do_success($auth->generate_token($_POST['user_id'])); // 文章修改成功
          exit();
        }
      }
    }
  }
}
$result->fail(); // 400 Bad Request
?>
