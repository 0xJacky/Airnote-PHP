<?php
/**
 * JianJi Post Model
 */
class post extends Model
{

  function __construct() {
    parent::__construct();
  }

  function post($user_id, $title, $content, $img, $type) {
    $sql = 'SELECT `status` FROM `api_users` WHERE `ID` = \''.$user_id.'\'';
    $r = $this->db->fetch_array($sql);
    if ($r['status'] == 0) {
      $result['status'] = 407;
      return $result;
    }
    $time = date("Y-m-d H:i:s", strtotime('now'));
    $time_gmt = date("Y-m-d H:i:s", strtotime('-8 hours'));
    $sql = "INSERT INTO `api_posts` (`author`, `post_date`, `post_date_gmt`, `title`, `content`, `img`, `favours`, `status`, `sha1_pwd`, `post_edited`, `post_edited_gmt`, `type`)";
    $sql .= "VALUES ('$user_id', '$time', '$time_gmt', '$title', '$content', '$img', 0, 1, 'NULL', '$time', '$time_gmt', '$type')";
    if( $this->db->query($sql) == false ) {
      $result['status'] = 503; // 503 DataBase Error
      return $result;
    } else {
      $result = array(
        'status' => 200,
        'content' => array(
          'token' => $this->auth->generate_token($user_id),
        ),
      );
      return $result;
    }
  }

  function edit($user_id, $post_id, $title, $content, $img, $type) {
    $sql = 'SELECT `author` FROM `api_posts` WHERE `ID` = \''.$post_id.'\'';
    $r = $this->db->fetch_array($sql);
    if ($r == NULL) {
      $result['status'] = 404;
      return $result;
    }
    if ($r['author'] !== $user_id) {
      $result['status'] = 403;
      return $result;
    }
    $sql = 'SELECT `status` FROM `api_users` WHERE `ID` = \''.$user_id.'\'';
    $r = $this->db->fetch_array($sql);
    if ($r['status'] == 0) {
      $result['status'] = 407;
      return $result;
    }
    if ($r == false) {
      $result['status'] = 503;
      return $result;
    }
    $time = date("Y-m-d H:i:s", strtotime('now'));
    $time_gmt = date("Y-m-d H:i:s", strtotime('-8 hours'));
    $sql = 'UPDATE `api_posts` SET `title` = \''.$title.'\', `content` = \''.$content.'\', `img` = \''.$img.'\', `post_edited` = \''.$time.'\', `post_edited_gmt` = \''.$time_gmt.'\', `sha1_pwd` = \''.$sha1_pwd.'\', `type` = \''.$type.'\' WHERE `ID` = \''.$post_id.'\'';
    if ($this->db->query($sql) == false) {
      $result['status'] = 503;
      return $result;
    }
    $result = array(
      'status' => 200,
      'content' => array(
        'token' => $this->auth->generate_token($user_id),
      ),
    );
    return $result;
  }

  function delete($user_id, $post_id) {
    $sql = 'SELECT `author` FROM `api_posts` WHERE `ID` = \''.$post_id.'\'';
    $r = $this->db->fetch_array($sql);
    if ($r == NULL) {
      $result['status'] = 404;
      return $result;
    }
    if ($r['author'] !== $user_id) {
      $result['status'] = 403;
      return $result;
    }
    $sql = 'SELECT `status` FROM `api_users` WHERE `ID` = \''.$user_id.'\'';
    $r = $this->db->fetch_array($sql);
    if ($r['status'] == 0) {
      $result['status'] = 407;
      return $result;
    }
    $sql = 'UPDATE `api_posts` SET `status` = 0 WHERE `ID` = \''.$post_id.'\'';
    if ($this->db->query($sql) == false) {
      $result['status'] = 503;
      return $result;
    }
    $result = array(
      'status' => 200,
      'content' => array(
        'token' => $this->auth->generate_token($user_id),
      ),
    );
    return $result;
  }

  function favour($user_id, $post_id) {
    $sql = 'SELECT `status` FROM `api_posts` WHERE `ID` = \''.$post_id.'\'';
    $r = $this->db->fetch_array($sql);
    if ($r == NULL or $r['status'] == 0) {
      $result['status'] = 404;
      return $result;
    }
    $sql = 'UPDATE `api_posts` SET `favours` = `favours`+1 WHERE `ID` = \''.$post_id.'\'';
    if ($this->db->query($sql) == false) {
      $result['status'] = 503;
      return $result;
    }
    $result = array(
      'status' => 200,
      'content' => array(
        'token' => $this->auth->generate_token($user_id),
      ),
    );
    return $result;
  }

  function list($page) {
    $page = $page * 10 - 10;
    $sql = 'SELECT `ID`, `author`, `post_date`, `title`, `img`, `favours` FROM `api_posts` WHERE `status` = 1 ORDER BY `post_date` LIMIT '.$page.', 10';
    $r = $this->db->fetch_all($sql);
    if ($r == false) {
      $result['status'] = 503;
      return $result;
    }

    for ($i=0; $i<count($r); $i++) {
      $sql = 'SELECT `avatar` FROM `api_users` WHERE `ID` = '.$r[$i]['author'];
      $a = $this->db->fetch_array($sql);
      $r[$i]['avatar'] = $a['avatar'];//将 api_users 中的头像数据插入到数组中
    }

    $result = array(
      'status' => 200,
      'content' => array(
        'post_list' => $r,
      ),
    );
    return $result;
  }

  function self_list($user_id, $page) {
    $page = $page * 10 - 10;
    $sql = 'SELECT `post_date`, `title`, `img`, `favours` FROM `api_posts` WHERE `ID`= '.$user_id.' AND `status` = 1 ORDER BY `post_date` LIMIT '.$page.', 10';
    $r = $this->db->fetch_all($sql);
    if ($r == false) {
      $result['status'] = 503;
      return $result;
    }
    $result = array(
      'status' => 200,
      'content' => array(
        'post_list' => $r,
      ),
    );
    return $result;
  }
}

?>
