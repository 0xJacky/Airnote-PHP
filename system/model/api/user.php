<?php
/**
 * API User class model
 */
if (!defined("IN_JIANJI")) {
    die();
}

class user_model extends Model
{

    function __construct()
    {
        parent::__construct();
        $this->auth = new auth();
    }

    function register($name, $pwd, $mail)
    {
        $try_mail = 'SELECT `user_mail` FROM `api_users` WHERE `user_mail` = \'' . $mail . '\'';
        $try_name = 'SELECT `user_name` FROM `api_users` WHERE `user_name` = \'' . $name . '\'';
        $result_name = $this->db->fetch_array($try_name);
        $result_mail = $this->db->fetch_array($try_mail);
        if ($result_name['user_name'] == $name && $result_mail['user_mail'] == $mail) {
            return $this->http->info(4051);
        }
        if ($result_name['user_name'] == $name) {
            return $this->http->info(4052);
        }
        if ($result_mail['user_mail'] == $mail) {
            return $this->http->info(4053);
        }
        $time = date("Y-m-d H:i:s", strtotime('now'));
        $sql = "INSERT INTO `api_users` (`name`, `sha1_pwd`, `mail`, `status`, `is_login`, `registered_time`, `lastest_active`, `token`, `avatar`, `introduction`)";
        $sql .= "VALUES ('$name', '$pwd', '$mail', 1, 1, '$time', '$time', 'NULL', 'NULL', 'NULL')";
        $result = $this->db->query($sql);
        if ($result == false) {
            return $this->http->info(503);
        } else {
            return $this->http->info(200); // 注册完成后请立即本地执行登录函数
        }
    }

    function login($mail, $pwd)
    {
        session_start();
        if ($_SESSION['try'] > 10 && time() < $_SESSION['lasttry']) {
            return $this->http->info(409);
        } else {
            $_SESSION['try'] = 0;
        }

        if (!isset($_SESSION['connected']) || $_SESSION['connected'] != true) {
            session_regenerate_id(true);
        } elseif ($_SESSION['connected'] === true) {
            $result = array(
                'status' => 200,
                'account_info' => array(
                    'ID' => $result['ID'],
                    'token' => $_SESSION['token']
                ),
            );
            return $this->http->response($result);
        }
        $try = 'SELECT `ID`, `sha1_pwd`, `mail`, `status` FROM `api_users` WHERE `mail` = \'' . $mail . '\'';
        $result = $this->db->fetch_array($try);
        if (empty($result) || $pwd !== $result['sha1_pwd']) {
            $_SESSION['try'] = $_SESSION['try'] + 1;
            $_SESSION['lasttry'] = time() + 300; // 五分钟
            return $this->http->info(406);
        } elseif ($result['status'] == 0) {
            $_SESSION['try'] = $_SESSION['try'] + 1;
            $_SESSION['lasttry'] = time() + 300;
            return $this->http->info(407);
        } elseif ($pwd == $result['sha1_pwd']) {
            $_SESSION['userid'] = $result['ID'];
            $_SESSION['try'] = 0;
            $_SESSION['connected'] = true;
            $token = $this->auth->generate_token($result['ID']);
            if ($this->db->query($sql) == false) {
                return $this->http->info(503);
            } else {
                $result = array(
                    'status' => 200,
                    'account_info' => array(
                        'ID' => $result['ID'],
                        'token' => $token
                    ),
                );
                return $this->http->response($result);
            }
        }
    }

    function logout()
    {
        session_start();
        if (!$_SESSION['connected']) {
            return $this->http->info(403);
        }
        $time = date("Y-m-d H:i:s", strtotime('now'));
        $sql = 'UPDATE `api_users` SET `is_login` = \'0\', `lastest_active` = \'' . $time . '\' WHERE `ID` = \'' . $_SESSION['userid'] . '\'';
        session_destroy();
        if ($this->db->query($sql)) {
            return $this->http->info(200);
        }
        return $this->http->info(503);
    }

    function info($mail)
    {
        session_start();
        if (!$_SESSION['connected']) {
            return $this->http->info(403);
        }
        $sql = 'SELECT `ID`, `name`, `registered_time`, `lastest_active`, `avatar`, `introduction` FROM `api_users` WHERE `mail` = \'' . $mail . '\'';
        $token = $this->auth->generate_token($_SESSION['token']);
        $result = $this->db->fetch_array($sql);
        $favours = $this->db->fetch_array('SELECT COUNT(`favours`) FROM `api_posts`, `api_users` WHERE api_users.mail = \'' . $mail . '\'');
        $result['avatar'] = !is_null($result['avatar']) ? $result['avatar'] : 'avatar/default.png';
        if (!empty($result['ID'])) {
            $result = array(
                'status' => 200,
                'user_info' => array(
                    'ID' => $result['ID'],
                    'Name' => $result['name'],
                    'registered_time' => $result['registered_time'],
                    'lastest_active' => $result['lastest_active'],
                    'avatar' => $result['avatar'],
                    'introduction' => $result['introduction'],
                    'favour' => $favours['COUNT(`favours`)'],
                    'token' => $token
                ),
            );
            return $this->http->response($result);
        }
        return $this->http->info(404);
    }

    function edit_profile($request, $content)
    {
        session_start();
        if (!$_SESSION['connected']) {
            return $this->http->info(403);
        }
        $time = date("Y-m-d H:i:s", strtotime('now'));
        $token = $this->auth->generate_token($_SESSION['userid']);
        $sql = 'UPDATE `api_users` SET `' . $request . '` = \'' . $content . '\', `lastest_active` = \'' . $time . '\' WHERE `ID` = \'' . $_SESSION['userid'] . '\'';
        if ($this->db->query($sql)) {
            $result = array(
                'status' => 200,
                'token' => $token
            );
            return $this->http->response($result);
        }
        return $this->http->info(503);
    }
}

?>
