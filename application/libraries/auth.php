<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth
{
	private $CI;
	private $session;
	
	public function __construct()
	{
		$this->CI = &get_instance();
		$this->session = 'passwd';
	}
	
	public function estConnecte()
	{
		if ($this->CI->session->userdata('passwd') != false)
			return true;
	}
	
	public function estSAdmin()
	{
		$this->CI->load->model('auth_model');
		if ($this->CI->session->userdata($this->session) == $this->CI->auth_model->getSuperAdmin())
			return true;
		return false;
	}

	public function seConnecter($hash)
	{
		$this->CI->load->model('auth_model');
		if ($hash == $this->CI->auth_model->getAdmin() || $hash == $this->CI->auth_model->getSuperAdmin())
		{
			$this->CI->session->set_userdata(array($this->session => $hash));
			return true;
		}
		else
			return false;
	}
	
	public function seDeconnecter()
	{
		$this->CI->session->unset_userdata($this->session);
	}
}
