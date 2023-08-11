<?php namespace App\Controllers;

class Login extends BaseController
{
	public function index()
	{
		return view('login');
	}

	public function auth()
	{
		$user_name 		= addslashes($this->request->getPost('username'));
		$user_password 	= $this->request->getPost('password');
		$sql 			= $this->db->query("select * from user where user.user_name='".$user_name."' and user.user_password='".sha1($user_password)."'");
		$data 			= $sql->getRowArray();
		if(!empty($data)){
			$this->session->set('user', $data);
			return redirect()->to(base_url("admin/home"));
		}else{
			$this->session->setFlashdata('warning','Login Gagal !');
			return redirect()->to(base_url("login"));
		}
	}

	public function logout()
    {
        $this->session->remove('user');
        return redirect()->to(base_url("login"));
    }
}
