<?php
/**
 * Airnote Router Class
 * 0xJacky 2017
 */

defined('BASE_PATH') OR exit('No direct script access allowed');

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

        //print_r($param);
        $class = $param[0];
        switch ($class) {
            case 'api':
                if (!isset($param[1])) {
                    return $this->http->info(200);
                }
                if (!isset($_POST['auth_key']) && !$auth->check_auth_key($_POST['auth_key'])) {
                    die($this->http->info(403));
                }
                $class = $param[1] . '_api';
                $method = $param[2];
                if (method_exists($this->$class, $method)) {
                    return $this->$class->$method();

                }
                break;
            case 'resouces':
                if (!file_exists($this->url)){
                    return $this->http->info(404);
                }
                break;
            default:
                $method = $param[1];

                if (method_exists($this->$class, $method)) {

                    return $this->$class->$method();

                }

                return $this->http->info(404);
                break;
        }
    }

}

?>
