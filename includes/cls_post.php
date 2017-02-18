<?php
/**
* 笺记 API 文章公用类库
* Copyright 2017 0xJacky
**/

class cls_post {
  function do_favour($user_id, $post_id)
  {
    global $db;
    $favour = $db->fetch_array('SELECT `favour` FROM `api_posts` WHERE `post_id` = '.$post_id);
    $favour = $favour['favour']+1;
    if ($db->query('UPDATE `api_posts` SET `favour` = '.$favour.' WHERE `ID` = '.$post_id)) {
        return true;
    }
    return false;
  }
}
?>
