<?php
/**
 * Model Setup Class
 */
class Model
{
  protected $db;
  function __construct() {
    $this->load = new load();
    $this->db = new db(DB_HOST, DB_USER, DB_PW, DB_NAME);
 }
}

?>
