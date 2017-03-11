<?php
/**
 * Controller Core
 */
 if (!defined("IN_JIANJI")) {
   exit();
 }
 
class Controller
{
  protected $view;

  public function __construct()
  {
    //$this->model = new model();
    $this->http = new http();
    $this->user = new user();
  }

  public function load($post, $content = '')
  {
    /*if ($_POST == NULL) {
      exit($this->http->info(501));
    }*/
    if (!file_exists(V_PATH.'/'.$post.'.php')) {
      exit($this->http->info(404));
    }
    return require(V_PATH.'/'.$post.'.php');
  }
}
?>
