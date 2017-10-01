<?php
/**
 * API Controller
 */
defined('BASE_PATH') OR exit('No direct script access allowed');

class post_api extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function post()
    {
        if ($this->is_ok('post'))
            $this->model->post->post($_POST['title'], $_POST['content'], $_POST['img'], $_POST['type']);
    }

    function edit()
    {
        if ($this->is_ok('edit'))
            $this->model->post->edit($_POST['post_id'], $_POST['title'], $_POST['content'], $_POST['img'], $_POST['type']);
    }

    function delete()
    {
        if ($this->is_ok('delete'))
            $this->model->post->delete($_POST['post_id']);
    }

    function favour()
    {
        if ($this->is_ok('favour'))
            $this->model->post->favour($_POST['post_id']);
    }

    function list()
    {
        if ($this->is_ok('list'))
            $this->model->post->list($_POST['page']);
    }

    function self_list()
    {
        if ($this->is_ok('self_list'))
            $this->model->post->self_list($_POST['page']);
    }

    function is_ok($action)
    {
        switch ($action) {
            case 'post':
                if (isset($_POST['title'], $_POST['content'], $_POST['img'], $_POST['type'])) {
                    $_POST['user_id'] = (int)$_POST['user_id'];// It has been check in security.php
                    $_POST['title'] = xss_clean($_POST['title']);
                    $_POST['content'] = xss_clean($_POST['content']);
                    $_POST['img'] = xss_clean($_POST['img']);
                    $_POST['type'] = (int)$_POST['type'];
                    return true;
                }
                die($this->http->info(400));
                break;
            case 'edit':
                if (isset($_POST['post_id'], $_POST['title'], $_POST['content'], $_POST['img'], $_POST['type'])) {
                    $_POST['user_id'] = (int)$_POST['user_id'];// It has been check in security.php
                    $_POST['post_id'] = (int)$_POST['post_id'];
                    $_POST['title'] = xss_clean($_POST['title']);
                    $_POST['content'] = xss_clean($_POST['content']);
                    $_POST['img'] = xss_clean($_POST['img']);
                    $_POST['type'] = (int)$_POST['type'];
                    return true;
                }
                die($this->http->info(400));
                break;
            case 'delete':
            case 'favour':
                if (isset($_POST['post_id'])) {
                    $_POST['post_id'] = (int)$_POST['post_id'];
                    return true;
                }
                die($this->http->info(400));
                break;
            case 'list':
            case 'self_list':
                if (isset($_POST['page'])) {
                    $_POST['page'] = (int)$_POST['page'];
                    return true;
                }
                die($this->http->info(400));
                break;
            default:
                die($this->http->info(400));
                break;
        }
    }
}


?>
