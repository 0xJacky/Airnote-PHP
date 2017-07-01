<?php
/**
 * JianJi Post Model
 */
if (!defined("IN_JIANJI")) {
    die();
}

class post_model extends Model
{

    function __construct()
    {
        parent::__construct();
        $this->auth = new auth();
    }

    function post($title, $content, $img, $type)
    {
        session_start();
        if (!$_SESSION['connected']) {
            return $this->http->info(403);
        }
        $sql = 'SELECT `status` FROM `api_users` WHERE `ID` = \'' . $_SESSION['user_id'] . '\''; // 查询用户状态
        $r = $this->db->fetch_array($sql);
        if ($r['status'] == 0) { // 账号被禁用
            return $this->http->info(407);
        }
        $user_id = $_SESSION['user_id'];
        $time = date("Y-m-d H:i:s", strtotime('now'));
        $time_gmt = date("Y-m-d H:i:s", strtotime('-8 hours')); // 转换为北京时间
        $sql = "INSERT INTO `api_posts` (`author`, `post_date`, `post_date_gmt`, `title`, `content`, `img`, `favours`, `status`, `sha1_pwd`, `post_edited`, `post_edited_gmt`, `type`)";
        $sql .= "VALUES ('$user_id', '$time', '$time_gmt', '$title', '$content', '$img', 0, 1, 'NULL', '$time', '$time_gmt', '$type')"; // 写入数据库
        if ($this->db->query($sql) == false) {
            return $this->http->info(503); // 数据库错误
        } else {
            $result = array(
                'status' => 200,
                'info' => 'Post Successful',
                'token' => $this->auth->generate_token($user_id),
            );
            return $this->http->response($result);
        }
    }

    function edit($post_id, $title, $content, $img, $type)
    {
        session_start();
        if (!$_SESSION['connected']) {
            return $this->http->info(403);
        }
        $user_id = $_SESSION['user_id'];
        $sql = 'SELECT `author` FROM `api_posts` WHERE `ID` = \'' . $post_id . '\''; // 查询文章状态
        $r = $this->db->fetch_array($sql);
        if ($r == NULL) { // 不存在的
            return $this->http->info(404);
        }
        if ($r['author'] !== $user_id) { // 用户不符合
            $result['status'] = 403;
            return $this->http->info(403);
        }
        $sql = 'SELECT `status` FROM `api_users` WHERE `ID` = \'' . $user_id . '\''; // 查询用户状态
        $r = $this->db->fetch_array($sql);
        if ($r['status'] == 0) { // 用户被禁用
            $result['status'] = 407;
            return $this->http->info(407);
        }
        if ($r == false) { // 数据库错误
            return $this->http->info(503);
        }
        $time = date("Y-m-d H:i:s", strtotime('now'));
        $time_gmt = date("Y-m-d H:i:s", strtotime('-8 hours'));
        $sql = 'UPDATE `api_posts` SET `title` = \'' . $title . '\', `content` = \'' . $content . '\', `img` = \'' . $img . '\', `post_edited` = \'' . $time . '\', `post_edited_gmt` = \'' . $time_gmt . '\', `sha1_pwd` = \'' . $sha1_pwd . '\', `type` = \'' . $type . '\' WHERE `ID` = \'' . $post_id . '\'';
        if ($this->db->query($sql) == false) {
            return $this->http->info(503);
        }
        $result = array(
            'status' => 200,
            'info' => 'Edit Successful',
            'token' => $this->auth->generate_token($user_id),
        );
        return $this->http->response($result);
    }

    function delete($user_id, $post_id)
    {
        session_start();
        if (!$_SESSION['connected']) {
            return $this->http->info(403);
        }
        $sql = 'SELECT `author` FROM `api_posts` WHERE `ID` = \'' . $post_id . '\'';
        $r = $this->db->fetch_array($sql);
        if ($r == NULL) {
            return $this->http->info(404);
        }
        if ($r['author'] !== $user_id) {
            return $this->http->info(403);
        }
        $sql = 'SELECT `status` FROM `api_users` WHERE `ID` = \'' . $user_id . '\'';
        $r = $this->db->fetch_array($sql);
        if ($r['status'] == 0) {
            return $this->http->info(407);
        }
        $sql = 'UPDATE `api_posts` SET `status` = 0 WHERE `ID` = \'' . $post_id . '\'';
        if ($this->db->query($sql) == false) {
            return $this->http->info(503);
        }
        $result = array(
            'status' => 200,
            'info' => 'Delete Successful',
            'token' => $this->auth->generate_token($user_id),
        );
        return $this->http->response($result);
    }

    function favour($post_id)
    {
        session_start();
        if (!$_SESSION['connected']) {
            return $this->http->info(403);
        }
        $user_id = $_SESSION['user_id'];
        $sql = 'SELECT `status` FROM `api_posts` WHERE `ID` = \'' . $post_id . '\'';
        $r = $this->db->fetch_array($sql);
        if ($r == NULL or $r['status'] == 0) {
            return $this->http->info(404);
        }
        $sql = 'UPDATE `api_posts` SET `favours` = `favours`+1 WHERE `ID` = \'' . $post_id . '\'';
        if ($this->db->query($sql) == false) {
            return $this->http->info(503);
        }
        $result = array(
            'status' => 200,
            'info' => 'Delete Successful',
            'token' => $this->auth->generate_token($user_id),
        );
        return $this->http->response($result);
    }

    function list($page)
    {
        /* 公共接口无需验证 session */
        $page = $page * 10 - 10;
        if ($page > 1) {
            $limit = $page - 10;
        } else {
            $limit = 10;
        }
        $sql = 'SELECT `api_posts`.`ID`, `avatar`, `post_date`, `title`, `img`, `favours` FROM `api_posts` INNER JOIN `api_users` on api_posts.author = api_users.ID WHERE `status` = 1 ORDER BY `post_date` LIMIT ' . $page . ',' . $limit;
        $list = $this->db->fetch_all($sql);
        if ($r == false) {
            return $this->http->info(503);
        }

        $result = array(
            'status' => 200,
            'article_list' => $list,
        );
        return $this->http->response($result);
    }

    function self_list($page)
    {
        session_start();
        if (!$_SESSION['connected']) {
            return $this->http->info(403);
        }
        $page = $page * 10 - 10;
        if ($page > 1) {
            $limit = $page - 10;
        } else {
            $limit = 10;
        }
        session_start();
        $sql = 'SELECT `post_date`, `title`, `img`, `favours` FROM `api_posts` WHERE `ID`= ' . $_SESSION['user_id'] . ' AND `status` = 1 ORDER BY `post_date` LIMIT ' . $page . ',' . $limit;
        $list = $this->db->fetch_all($sql);
        if ($r == false) {
            return $this->http->info(503);
        }
        $result = array(
            'status' => 200,
            'article_list' => $list,
        );
        return $result;
    }
}

?>
