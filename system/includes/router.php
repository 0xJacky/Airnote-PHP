<?php
/**
 * JianJi Router Class
 * 0xJacky 2017
 */

 if (!defined("IN_JIANJI")) {
   die();
 }

class Router
{

  function __construct($_Controllers)
  {
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->url = $_SERVER['PATH_INFO'];
    $this->http = new http();

    $this->frontend = new frontend();
    $this->admin = new admin();
    $this->user = new user();
    $this->post = new post();
  }

  private function home($frontend, $home) {
    /* 当 PATH_INFO 为空时，即访问主页时提前跳转至主页控制器 */
    return $frontend->$home();
  }

  function add($route, $class, $callback) {
    /* 添加路由规则 */
    $this->rules[$route] = $class->$callback();
  }

  function run() {
    $matched = False;
    /* 循环检测 PATH_INFO 与路由规则的配对 */
    foreach ($this->rules as $route => $callback) {
      if ($route == $this->url) {
        $matched = True;
        $callback();
        break;
      }
    }
    /* 未能匹配，跳转至 404 页面 TODO: http class 404 对非 api 的请求输出 HTML */
    if (!$matched) {
      $this->http->info(404);
    }
  }

  /**
    * Auto run router
    * Usage: auto_run($frontend, $home);
    * The params are used to display index page, when the $this->url is null.
    * @author: 0xJacky
  */
  function auto_run($frontend, $home) {

    if (empty($this->url)) {

      return $this->home($frontend, $home);

    }

          // 重置数组索引值    清除空键             Explode 为数组
    $param = array_values(array_filter(explode('/', $this->url)));

    print_r($param);
    $class = $param[0];
    $method = $param[1];

    if (method_exists($this->$class, $method)) {

      return $this->$class->$method();

    }

    return $this->http->info(404);
  }

}

?>
