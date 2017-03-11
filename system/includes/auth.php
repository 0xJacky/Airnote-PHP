<?php
/**
* 笺记 API 检查连接密钥 公用类库
* Copyright 2017 0xJacky
**/
if ( !defined('IN_JIANJI') ) {
  die();
}
class auth
{

  function check_auth_key($check_auth_key)
  {
    /**
    * Auth_key 内存放的信息：UNIX时间戳+密钥；
    * 请提交已用 md5 加密过的数据
    **/
    $key_raw = time().$salt;
    $key = md5($key_raw);
    //$salt = 0;
    if ($key == $check_auth_key);
    {
      return true;
    }
    return false;
  }

  function check_token($user_token)
  {
    /**
    * Token 内存放的信息：base64_encode(ID-当前时间戳-盐)
    * 请提交已用 base64 加密过的数据
    **/
    $sql = 'SELECT * FROM `api_users` WHERE `user_token` = \''.$user_token.'\'';
    $result = $db->fetch_array($sql);
    $token = explode('-', base64_decode($user_token));
    $id = $token[0];
    if ( $id == $result['ID'] )
    {
      return true;
    }
    return false;
  }

  function uozi_rand( $min = 0, $max = 0 ) {
  	global $rnd_value;
  	// Reset $rnd_value after 14 uses
  	// 32(md5) + 40(sha1) + 40(sha1) / 8 = 14 random numbers from $rnd_value
  	if ( strlen($rnd_value) < 8 )
    {
  		static $seed = '';
  		$rnd_value = md5( uniqid(microtime() . mt_rand(), true ) . $seed );
  		$rnd_value .= sha1($rnd_value);
  		$rnd_value .= sha1($rnd_value . $seed);
  		$seed = md5($seed . $rnd_value);
  	}
  	// Take the first 8 digits for our value
  	$value = substr($rnd_value, 0, 8);
  	$rnd_value = substr($rnd_value, 8);
  	$value = abs(hexdec($value));
  	// Some misconfigured 32bit environments (Entropy PHP, for example) truncate integers larger than PHP_INT_MAX to PHP_INT_MAX rather than overflowing them to floats.
  	$max_random_number = 3000000000 === 2147483647 ? (float) "4294967295" : 4294967295; // 4294967295 = 0xffffffff
  	// Reduce the value to be within the min - max range
  	if ( $max != 0 )
  		$value = $min + ( $max - $min + 1 ) * $value / ( $max_random_number + 1 );
  	return abs(intval($value));
  }

  function generate_password( $length = 12, $special_chars = true, $extra_special_chars = false )
  {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    if ( $special_chars )
    $chars .= '!@#$%^&*()';
    if ( $extra_special_chars )
    $chars .= '-_ []{}<>~`+=,.;:/?|';
      $password = '';
      for ( $i = 0; $i < $length; $i++ )
      {
        $password .= substr($chars, $this->uozi_rand(0, strlen($chars) - 1), 1);
      }
      return $password;
  }

  function generate_token($id)
  {
    $string = $id.'-'.time().'-'.$this->generate_password( $length = 16 );
    $token = base64_encode($string);
    return $token;
  }
}
?>
