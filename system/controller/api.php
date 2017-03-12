<?php
/**
 * API Controller
 */

class API extends Controller
{
  function __construct() {
    parent::__construct();
  }

  function ping() {
    $this->http->info(200);
  }

  function user_login() {
    $this->load('user/login');
  }

  function user_logout() {
    $this->load('user/logout');
  }

  function user_register() {
    $this->load('user/register');
  }

  function user_info() {
    $this->load('user/info');
  }

  function user_edit_profile() {
    $this->load('user/edit_profile');
  }

  function post_list() {
    $this->load('post/list');
  }

  function post_content() {
    $this->load('post/content');
  }

  function edit_content() {
    $this->load('post/edit_content');
  }

  function delete_content() {
    $this->load('post/delete_content');
  }

  function favour_content() {
    $this->load('post/favour_content');
  }
}


?>
