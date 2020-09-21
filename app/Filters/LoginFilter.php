<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $this->session = \Config\Services::session();
		if($this->session->get('user')==NULL){
            return redirect()->to(base_url('login'));
		}   
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}