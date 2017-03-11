<?php
/**
 * Controller Core
 */
class Controller
{
  protected $view;

  public function __construct()
  {
    //$this->model = new model();
    $this->http = new http();
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
