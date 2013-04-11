<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function index()
	{
		$this->theme->set_titre('Accueil');
		$donnees = array('variables' => '');
		$this->theme->view('welcome_message', $donnees);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
