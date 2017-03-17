<?php
/**
* JianJi MySQLi Common Class Library
*/

if ( !defined('IN_JIANJI') ) {
  die();
}

class db {

    var $error_message  = array();

    function __construct($db_host, $db_user, $db_pw, $db_name) {

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

    function fetch_all($sql, $result_type = MYSQLI_ASSOC)
    {
      $sql = $this->query($sql);
      return mysqli_fetch_all($sql, $result_type);
    }

    function result($query, $row = 0)
    {
			$result = false;
			$numrows = mysqli_num_rows($query);
			if ($numrows && $row <= ($numrows - 1) && $row >=0){
				mysqli_data_seek($query, $row);
				$resrow = mysqli_fetch_row($query);
				if (isset($resrow[0])){
					$result = $resrow[0];
				}
			}
  		return $result;
    }

    function real_escape_string($data) {
      return mysqli_real_escape_string($this->link_id, $data);
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
            echo "API DataBase info: $message";
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
