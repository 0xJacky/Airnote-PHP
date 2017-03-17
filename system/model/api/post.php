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
}

?>
