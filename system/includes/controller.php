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
    $this->model = new model();
    $this->model->user = new user_model();
    $this->model->post = new post_model();
  }

  public function load($file, $dir)
  {
    if (!file_exists(V_PATH.'/'.$dir.'/'.$file.'.php')) {
      exit($this->http->info(404));
    }
    return require(V_PATH.'/'.$dir.'/'.$file.'.php');
  }
}
?>
