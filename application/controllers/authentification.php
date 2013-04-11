<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Authentification extends MY_Controller {

	public function index()
	{
		if ($this->auth->estConnecte())
		{
			if ($this->auth->estSAdmin())
				$this->indexSAdmin();
			else
				redirect('/', 'refresh');
		}
		else
			$this->indexDeconnecte();
	}
	
	private function indexDeconnecte()
	{
		$this->form_validation->set_rules('id', 'identité', 'trim|required|xss_clean');
		$this->form_validation->set_rules('mdp', 'mot de passe', 'trim|required|xss_clean|callback_auth_check'); 
		
		if ($this->form_validation->run() == true)
		{
			if ($this->auth->seConnecter(genererHash($this->input->post('mdp'))))
			{
				$this->session->set_flashdata('info', 'Connexion réussie !');
				redirect($this->input->post('redirection'), 'refresh');
			}
			else
			{
				$this->session->set_flashdata('info', 'Impossible de se connecter.');
				redirect('/', 'refresh');
			}
			

		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			if (isset($_POST['redirection'])) $redirection = $_POST['redirection'];
			else $redirection = $this->session->flashdata('arrivee');

			// $donnees['id'] géré directement dans la vue
			
			$donnees['mdp'] = array('name' => 'mdp',
				'id' => 'mdp',
				'type' => 'password',
			);
			$donnees['redirection'] = array('name' => 'redirection',
				'id' => 'redirection',
				'type' => 'hidden',
				'value' => $redirection);

			$this->theme->set_titre('Authentification');
			$this->theme->view('auth/index', $donnees);
		}
	}
	
	private function indexSAdmin()
	{
		$this->form_validation->set_rules('id', 'identité', 'trim|required|xss_clean');
		$this->form_validation->set_rules('mdp', 'mot de passe', 'trim|required|xss_clean|min_length[6]|callback_check_confirm');
		$this->form_validation->set_rules('cmdp', 'confirmation mot de passe', 'trim|required|xss_clean|min_length[6]|callback_check_confirm'); 
		
		if ($this->form_validation->run() == true)
		{
			$this->load->model('auth_model');
			$hash = genererHash($this->input->post('mdp'));
			$message = 'Impossible de changer le mot de passe.';
			
			if ($this->input->post('id') == 'admin')
			{
				if ($this->auth_model->setAdmin($hash))
				{
					$this->auth->seConnecter($hash);
					$message = 'Modification réussie !';
				}
			}
			elseif ($this->input->post('id') == 'sadmin')
			{
				if ($this->auth_model->setSuperAdmin($hash))
				{
					$this->auth->seConnecter($hash);
					$message = 'Modification réussie !';
				}
			}
			
			$this->session->set_flashdata('info', $message);
			redirect('/', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// $donnees['id'] géré directement dans la vue
			
			$donnees['mdp'] = array('name' => 'mdp',
				'id' => 'mdp',
				'type' => 'password'
			);
			
			$donnees['cmdp'] = array('name' => 'cmdp',
				'id' => 'cmdp',
				'type' => 'password'
			);

			$this->theme->set_titre('Modification des mots de passe');
			$this->theme->view('auth/mdp', $donnees);
		}

	}
	
	public function deconnexion()
	{
		if ($this->auth->estConnecte())
			$this->auth->seDeconnecter();
			
		redirect('/', 'refresh');
	}
	
	public function auth_check($mdp)
	{
		$hash = genererHash($mdp);
		$this->load->model('auth_model');
		
		if ($this->input->post('id') == 'admin')
		{
			if ($hash == $this->auth_model->getAdmin())
				return true;
			else
			{
				$this->form_validation->set_message('auth_check', 'Mot de passe incorrect');
				return false;
			}
		}	
		elseif ($this->input->post('id') == 'sadmin')
		{
			if ($hash == $this->auth_model->getSuperAdmin())
				return true;
			else
			{
				$this->form_validation->set_message('auth_check', 'Mot de passe incorrect');
				return false;
			}
		}
		else
		{
			$this->form_validation->set_message('auth_check', 'Identité non reconnue');
			return false;
		}
	}
}
