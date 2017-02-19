<?php
/**
 * 笺记 API MySQLi 公用类库
 * By 0xJacky
 * 2017-1-20
**/

if ( !defined('IN_JianJi') && !defined('ROOT_PATH') ) {
  die('Boom');
}

class cls_mysqli {

    var $error_message  = array();

    function __construct($db_host, $db_user, $db_pw, $db_name) {

      $this->cls_mysqli($db_host, $db_user, $db_pw, $db_name);

    }

    function cls_mysqli($db_host, $db_user, $db_pw, $db_name) {

        $this->connect($db_host, $db_user, $db_pw, $db_name);

    }

    function connect($db_host, $db_user, $db_pw, $db_name) {

        if ( ! mysqli_connect($db_host, $db_user, $db_pw) ) {

          $this->ErrorMsg("Can't Connect MySQL Server($db_host)!");

        } else {

          $this->link_id = @mysqli_connect($db_host, $db_user, $db_pw);

        }

        if ($db_name)
        {
            if (mysqli_select_db($this->link_id, $db_name) === false )
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }

    function select_database($db_name)
    {
        return mysqli_select_db($this->link_id, $db_name);
    }

    function query($sql)
    {

        if (!($query = mysqli_query($this->link_id, $sql)))
        {
            $this->error_message[]['message'] = 'MySQL Query Error';
            $this->error_message[]['sql'] = $sql;
            $this->error_message[]['error'] = mysqli_error($this->link_id);
            $this->error_message[]['errno'] = mysqli_errno($this->link_id);

            $this->ErrorMsg();

            return false;
        }

        return $query;
    }

    function fetch_array($query, $result_type = MYSQLI_ASSOC)
    {
        if ($query) {
          $query_output = mysqli_query($this->link_id, $query);
          return mysqli_fetch_array($query_output, $result_type);
        }
        else
        {
          return NULL;
        }
    }

    function fetch_row($query)
    {
        return mysqli_fetch_assoc($query);
    }

    function fetch_all($sql)
    {
      $sql = $this->query($sql);
      //$array =  mysqli_fetch_array($sql);
      $result = $sql->fetch_all();
      //print_r($result[$i]);
      $num = count($result);
      global $user;
      for($i=0; $i<$num; $i++) {
        $list[$i]['post_id'] = $result[$i][0];
        $author = $this->fetch_array('SELECT * FROM `api_users` WHERE `ID` = '.$result[$i][1]);
        $list[$i]['post_avatar'] = $user->get_option($result[$i][1], 'avatar');
        $list[$i]['post_author'] = $author['user_displayname'];
        $list[$i]['post_title'] = $result[$i][2];
        $list[$i]['post_img'] = $result[$i][3];
        $list[$i]['favour'] = $result[$i][4];
      }
      return $list;
    }

    function free_result($data)
    {
      return mysqli_free_result($data);
    }

    function close()
    {
        return mysqli_close($this->link_id);
    }


    function error()
    {
        return mysqli_error($this->link_id);
    }

    function errno()
    {
        return mysqli_errno($this->link_id);
    }

    function ErrorMsg($message = '', $sql = '')
    {
        if ($message)
        {
            echo "API info: $message";
        }
        else
        {
            echo "MySQL server error report:";
            print_r($this->error_message);
        }

        exit;
    }
}
?>
