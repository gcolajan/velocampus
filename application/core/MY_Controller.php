<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		if (!$this->auth->estConnecte())
		{
			$this->session->set_flashdata('arrivee', '/'.$this->uri->uri_string());
			if ($this->router->fetch_class() != 'authentification')
			{
				redirect('/authentification', 'refresh');
				exit();
			}
		}
	}
}
