<?php
/**
 * API Controller
 **/
if (!defined("IN_AIRNOTE")) {
    die();
}

class user_api extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function register()
    {
        if ($this->is_ok('register'))
            $this->model->user->register($_POST['name'], $_POST['pwd'], $_POST['mail']);
    }

    function login()
    {
        if ($this->is_ok('login'))
            $this->model->user->login($_POST['mail'], $_POST['pwd']);
    }

    function logout()
    {
        $this->model->user->logout();
    }

    function info()
    {
        if ($this->is_ok('info'))
            $this->model->user->info($_POST['mail']);
    }

    function edit_profile()
    {
        if ($this->is_ok('edit_profile'))
            $this->model->user->edit_profile($_POST['request'], $_POST['content']);
    }

    function is_ok($action)
    {
        switch ($action) {
            case 'login':
                if (isset($_POST['mail'], $_POST['pwd'])) {
                    $_POST['mail'] = xss_clean($_POST['mail']);
                    $_POST['pwd'] = xss_clean($_POST['pwd']);
                    return true;
                }
                die($this->http->info(400));
                break;
            case 'register':
                if (isset($_POST['name'], $_POST['pwd'], $_POST['mail'])) {
                    $_POST['name'] = xss_clean($_POST['name']);
                    $_POST['pwd'] = xss_clean($_POST['pwd']);
                    $_POST['mail'] = xss_clean($_POST['mail']);
                    return true;
                }
                die($this->http->info(400));
                break;
            case 'info':
                if (isset($_POST['mail'])) {
                    $_POST['mail'] = xss_clean($_POST['mail']);
                    return true;
                }
                die($this->http->info(400));
                break;
            case 'edit_profile':
                if (isset($_POST['request'], $_POST['content'])) {
                    $_POST['request'] = xss_clean($_POST['request']);
                    $_POST['content'] = xss_clean($_POST['content']);
                    return true;
                }
                die($this->http->info(400));
                break;

            default:
                die($this->http->info(501));
                break;
        }
    }
}


?>
