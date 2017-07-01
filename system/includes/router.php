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

    function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['PATH_INFO'];
        $this->http = new http();

        $this->frontend = new frontend();
        $this->admin = new admin();
        $this->user_api = new user_api();
        $this->post_api = new post_api();
    }

    function run()
    {
        if (empty($this->url)) { // 当参数为空时，跳转到首页

            return $this->frontend->home();

        }

        //       重置数组索引值    清除空键             Explode 为数组
        $param = array_values(array_filter(explode('/', $this->url)));

        print_r($param);
        $class = $param[0];
        if ($class == 'api') {
            if(!isset($param[1])){return $this->http->info(404);}
            $class = $param[1].'_api';
            $method = $param[2];
            if (method_exists($this->$class, $method)) {
                return $this->$class->$method();

            }
        }
        $method = $param[1];

        if (method_exists($this->$class, $method)) {

            return $this->$class->$method();

        }

        return $this->http->info(404);
    }

}

?>
