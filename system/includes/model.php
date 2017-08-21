<?php
/**
 * Model Setup Class
 */
if (!defined("IN_AIRNOTE")) {
    exit();
}

class Model
{
    protected $db;

    function __construct()
    {
        $this->db = new db(DB_HOST, DB_USER, DB_PW, DB_NAME);
        $this->http = new http();
    }
}

?>
