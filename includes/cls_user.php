<?php
/**
* 笺记 API User 公用类库
* Copyright 2017 0xJacky
**/

class cls_user {
  function get_option( $user_id, $option ) {
    global  $helper;
    $option = trim( $option );
    if ( empty( $option ) && empty( $user_id  ) )
    {
      return false;
    }
    global $db;
    $row = $db->fetch_array('SELECT `meta_value` FROM `api_usermeta` WHERE `user_id` = '.$user_id.' AND `meta_key` = \''.$option.'\'');
    if ($row['meta_value']) {
      $value = $row['meta_value'];
    } else {
      return NULL;
    }
    return $helper->maybe_unserialize( $value );
  }

  function update_option( $user_id, $option, $value ) {
    $option = trim($option);
    $value = htmlspecialchars($value);
    if ( empty($option) )
    {
      return false;
    }
    if ( is_object( $value ) ) {
      $value = clone $value;
    }
    $old_value = $this->get_option( $user_id, $option );
    // If the new and old values are the same, no need to update.
    if ( $value === $old_value )
    {
      return true;
    }
    if ( false === $old_value )
    {
      return add_option( $user_id, $option, $value );
    }
    global $helper;
    $serialized_value = $helper->maybe_serialize( $value );
    global $db;
    $result = $db->query('UPDATE `api_usermeta` SET `meta_value` = \''.$value.'\' WHERE `user_id` = '.$user_id.' AND `meta_key` = \''.$option.'\'');
    if ( ! $result ) {
      return false;
    }
    return true;
  }

  function add_option( $user_id, $option, $value = '') {
    $option = trim($option);
    if ( empty($option) )
    {
      return false;
    }
    if ( is_object($value) )
    {
      $value = clone $value;
    }
    global $helper;
    $serialized_value = $helper->maybe_serialize( $value );
    global $db;
    $result = $db->query('INSERT INTO `api_usermeta` (`user_id`, `meta_key`, `meta_value`) VALUES (\''.$user_id.'\',\''.$option.'\',\''.$value.'\');');
    if ( ! $result )
    {
      return false;
    }
    return true;
  }

  function get_info($result)
  {
    global $db;
    if ( !empty($result) ) {
      $user_id = $result['ID'];
      $mail = $result['user_mail'];
      $sql_post = 'SELECT COUNT(*) FROM `api_posts` WHERE post_author = '.$user_id;
      $post_num = $db->fetch_array($sql_post);
      $post_num = $post_num['COUNT(*)'];
      global $auth;
      $has_profile = $this->get_option($user_id, 'has_profile');
      $mobile = $this->get_option($user_id, 'mobile');
      $avatar = $this->get_option($user_id, 'avatar');
      $birthday = $this->get_option($user_id, 'birthday');
      $gender = $this->get_option($user_id, 'gender');
      $province = $this->get_option($user_id, 'province');
      $area = $this->get_option($user_id, 'area');
      $introduction = $this->get_option($user_id, 'introduction');
      $token = $auth->generate_token($user_id);
      $sql = 'UPDATE `api_users` SET `user_token` = \''.$token.'\' WHERE `ID` = \''.$user_id.'\'';
      $db->query($sql);

      $message = array(
        'error' => 0,
        'user_id' => $user_id,
        'mail' => $mail,
        'registered_time' => $result['registered_time'],
        'lastest_login' => $result['lastest_login'],
        'post_count' => $post_num,
        'has_profile' => $has_profile,
        'profile' => array(
          'mobile' => $mobile,
          'avatar' => $avatar,
          'birthday' => $birthday,
          'gender' => $gender, // 0:girl 1:boy 2:unknow
          'province' => $province,
          'area' => $area,
          'introduction' => $introduction
        ),
        'token' => $token
      );
      if ( $has_profile == 1 ) {
        if ( $post_num[0] >= 0 && $mobile && $birthday && $gender >= 0 && $province && $area && $introduction ) {
          return $message;
        }
      } else {
        unset($message['profile']);
        return $message;
      }
    }
    $message['error'] = 503;
    $message['timestamp'] = time();
    return false;
  }

  function upload_avatar($id, $img)
  {
    $result = $this->update_option($id, 'avatar', $img);
    return $result;
  }

  function edit_info($id, $profile)
  {
    $result = $this->update_option($id, 'mobile', $profile['mobile']);
    $result = $this->update_option($id, 'birthday', $profile['birthday']);
    $result = $this->update_option($id, 'gender', $profile['gender']);
    $result = $this->update_option($id, 'province', $profile['province']);
    $result = $this->update_option($id, 'area', $profile['area']);
    $result = $this->update_option($id, 'introduction', $profile['introduction']);

    return $result;
  }
}
?>
