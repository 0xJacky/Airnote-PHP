<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 2017/10/1
 * Time: 下午9:01
 */

class Admin extends CI_Controller {

	public $data;

	public function __construct() {
			parent::__construct();
			$this->data['method'] = $this->router->fetch_method();
			if ((isset($_SESSION['connected']) && !$_SESSION['connected']) || !isset($_SESSION['connected']) && $this->data['method'] != 'login') {
				redirect('admin/login?redirect='.$this->uri->uri_string());
			}
			$this->data['sidebars'] = [
				[
					'label' => 'DashBoard',
					'url'   => 'index',
					'i'     => 'fa-th-large'
				],
				[
					'label' => '用户管理',
					'url'   => 'manage_user',
					'i'     => 'fa-user'
				],
				[
					'label' => '文章管理',
					'url'   => 'manage_post',
					'i'     => 'fa-sticky-note'
				],
				[
					'label' => '权限',
					'url'   => 'power',
					'i'     => 'fa-terminal'
				],
				[
					'label' => '设置',
					'url'   => 'settings',
					'i'     => 'fa-cog'
				],
				[
					'label' => '统计',
					'url'   => 'stat',
					'i'     => 'fa-line-chart'
				],

				[
					'label' => '关于',
					'url'   => 'about',
					'i'     => 'fa-star'
				],

			];
			//$this->output->enable_profiler(TRUE);
	}

	public function login() {
		$this->load->helper('form');

		$this->load->library('form_validation');
		$config = [
			[
				'field' => 'username',
				'label' => 'Username',
				'rules' => 'required',
			],
			[
				'field'  => 'password',
				'label'  => 'Password',
				'rules'  => 'required',
				'errors' => [
					'required' => 'You must provide a %s.',
				],
			],
		];

		$this->form_validation->set_rules($config);

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			if (!isset($_SESSION['failture']) || isset($_SESSION['failture'],$_SESSION['lasttry']) && $_SESSION['failture'] > 10 && $_SESSION['lasttry'] < time())
			{
				$_SESSION['failture'] = 0;
			}

			if ($_SESSION['failture'] < 10)
			{
				if ($this->form_validation->run() && $this->handle_login())
				{
					redirect('admin/index');
				}
				else
				{
					$_SESSION['failture'] = $_SESSION['failture'] ? $_SESSION['failture'] + 1 : 1;
					$this->form_validation->set_message('username', '用户名与密码不匹配');
					return $this->load->view('admin/login');
				}
			}
			else
			{
				$_SESSION['lasttry'] = $_SESSION['lasttry'] ? $_SESSION['lasttry'] : time() + 300;
				$this->form_validation->set_message('username', '错误次数过多，请于 5 分钟之后尝试');
			}

		}
		elseif (isset($_SESSION['connected']) && $_SESSION['connected'])
		{
			$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'admin/index';
			redirect($redirect);
		}
		$this->load->view('admin/login');
	}

	private function handle_login() {
		$sql    = 'SELECT `sha1_pwd` FROM ' . $this->db->dbprefix('admin')
		          . ' WHERE `name`=' . '\'' . $_POST['username'] . '\'';
		$query  = $this->db->query($sql);
		$result = $query->row_array();
		if ($result['sha1_pwd'] == sha1($_POST['password']))
		{
			$_SESSION = array(
				'username'  => $_POST['username'],
				'failture'  => 0,
				'lasttry'   => 0,
				'connected' => TRUE
			);
			return TRUE;
		}
		return FALSE;
	}

	public function index() {
		$this->load->view('admin/header', $this->data);
		$this->load->view('admin/index');
		$this->load->view('admin/footer');
	}

	public function logout() {
		session_destroy();
		redirect('admin/login');
	}

	public function about() {
		$this->load->view('admin/header', $this->data);
		$this->load->view('admin/about');
		$this->load->view('admin/footer');
	}
}