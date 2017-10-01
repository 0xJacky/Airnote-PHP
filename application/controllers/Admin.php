<?php
/**
 * Created by PhpStorm.
 * User: Jacky
 * Date: 2017/10/1
 * Time: 下午9:01
 */

class Admin extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function login() {
		$this->load->helper(['form', 'url']);

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
			if (isset($_SESSION['failture']) && $_SESSION['failture'] > 10 && $_SESSION['lasttry'] < time())
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
					$this->form_validation->set_message('rule', 'Error Message');
					return $this->load->view('admin/login');
				}
			}
			else
			{
				$_SESSION['lasttry'] = $_SESSION['lasttry'] ? $_SESSION['lasttry']
					: time() + 300;
				$this->form_validation->set_message('rule', 'Error Message');
			}

		}
		elseif (isset($_SESSION['connected']) && $_SESSION['connected'])
		{
			redirect('admin/index');
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
		$this->load->view('admin/header');
		$this->load->view('admin/index');
		$this->load->view('admin/footer');
	}
}