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
    $this->http = new http();
    $this->user = new user();
    //$this->post = new post();
  }

  public function load($post, $content = '')
  {
    if (!file_exists(V_PATH.'/'.$post.'.php')) {
      exit($this->http->info(404));
    }
    return require(V_PATH.'/'.$post.'.php');
  }
}
?>
