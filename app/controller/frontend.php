<?php
/**
* API Controller
*/
if (!defined("BASE_PATH")) {
  die();
}

class frontend extends Controller
{
  function __construct() {
    parent::__construct();
  }

  function home() {
    return $this->view('home','frontend');
  }
}


?>
