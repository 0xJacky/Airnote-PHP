<?php
/**
* API Controller
*/
if (!defined("IN_JIANJI")) {
  die();
}

class frontend extends Controller
{
  function __construct() {
    parent::__construct();
  }

  function home() {
    echo 'Hello World';
  }
}


?>
