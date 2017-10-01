<?php
/**
 * 笺记 API 检查连接密钥 公用类库
 * Copyright 2017 0xJacky
 **/
defined('BASE_PATH') OR exit('No direct script access allowed');

class auth extends Model
{
    function __construct()
    {
        parent::__construct();
        $this->http = new http();
    }

    function check_auth_key($auth_key)
    {
        /**
         * Auth Key 内存放的信息：UNIX时间戳  + 密钥；
         * 请提交已用 sha1 加密过的数据
         **/
        if (IN_DEBUG) {
            return true;
        }
        $str = time() . SALT;
        $key = sha1($str);
        if ($key == $auth_key) {
            return true;
        }
        return false;
    }

    function check_token($user_id, $token)
    {
        /**
         * Token 内存放的信息：用户 ID - 干扰 1 - 干扰 2 - 干扰 3 - 最后活跃时间
         * 用户 ID 及 最后活跃时间已被 sha1 加密
         **/
        session_start();
        if (IN_DEBUG) {
            return true;
        }
        $user_id = strtoupper(sha1($user_id . SALT));
        $user_id = substr($user_id, 0, 8);
        $token = explode('-', $token);
        if ($token[0] !== $user_id) {
            return $this->http->response(403, 'Your Token is invalid');
        }
        $sql = 'SELECT `lastest_active` FROM `api_users` WHERE `ID` = \'' . (int)$user_id . '\'';
        $result = $this->db->fetch_array($sql);
        $lastest_active = strtoupper(sha1(strtotime($result['lastest_active'])));
        $lastest_active = substr($lastest_active, 0, 12);
        if ($token[4] !== $lastest_active) {
            return $this->http->response(408, 'Your Token is overdue, please relogin');
        }

        if ( $_SESSION['token'] == $token) {
            return $this->http->response(406, 'User ID or Token is invalid');
        }

        return false;
    }

    function uozi_rand($min = 0, $max = 0)
    {
        global $rnd_value;
        // Reset $rnd_value after 14 uses
        // 32(md5) + 40(sha1) + 40(sha1) / 8 = 14 random numbers from $rnd_value
        if (strlen($rnd_value) < 8) {
            static $seed = '';
            $rnd_value = md5(uniqid(microtime() . mt_rand(), true) . $seed);
            $rnd_value .= sha1($rnd_value);
            $rnd_value .= sha1($rnd_value . $seed);
            $seed = md5($seed . $rnd_value);
        }
        // Take the first 8 digits for our value
        $value = substr($rnd_value, 0, 8);
        $rnd_value = substr($rnd_value, 8);
        $value = abs(hexdec($value));
        // Some misconfigured 32bit environments (Entropy PHP, for example) truncate integers larger than PHP_INT_MAX to PHP_INT_MAX rather than overflowing them to floats.
        $max_random_number = 3000000000 === 2147483647 ? (float)"4294967295" : 4294967295; // 4294967295 = 0xffffffff
        // Reduce the value to be within the min - max range
        if ($max != 0)
            $value = $min + ($max - $min + 1) * $value / ($max_random_number + 1);
        return abs(intval($value));
    }

    function generate_password($length = 12, $special_chars = true, $extra_special_chars = false)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ0123456789';
        if ($special_chars)
            $chars .= '!@#$%^&*()';
        if ($extra_special_chars)
            $chars .= '-_ []{}<>~`+=,.;:/?|';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= substr($chars, $this->uozi_rand(0, strlen($chars) - 1), 1);
        }
        return $password;
    }

    function generate_token($user_id, $write = true)
    {
        $sha1_id = strtoupper(sha1($user_id . SALT));
        $time = strtoupper(sha1(time()));
        $pwd = strtoupper(sha1($this->generate_password(12, 0)));
        $token = substr($sha1_id, 0, 8) . '-';
        $token .= substr($pwd, 0, 4) . '-';
        $token .= substr($pwd, 4, 4) . '-';
        $token .= substr($pwd, 8, 4) . '-';
        $token .= substr($time, 0, 12);
        $time = date("Y-m-d H:i:s", strtotime('now'));
        if ($write) {
            session_start();
            $_SESSION['token'] = $token;
            $sql = 'UPDATE `api_users` SET `lastest_active` = \'' . $time . '\' WHERE `ID` = \'' . $user_id . '\''; // TODO: Access to redis
            if (!$this->db->query($sql)) {
                return $http->info(503);
            }
        }
        return $token;
    }
}

?>
