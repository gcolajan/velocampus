<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statut extends MY_Controller {

	public function index()
	{
		$this->theme->set_titre('Liste des statuts');
		$this->load->model('statut_model', 'statut');
		$donnees = array(
			'statuts' => $this->statut->listeStatuts(),
		 	'info' => $this->session->flashdata('info'));
		$this->theme->view('statut/index', $donnees);
	}
	
	private function reglesFormulaire()
	{
		$this->form_validation->set_rules('statut', 'Statut',
		'trim|required|xss_clean|max_length[32]|min_length[3]'); 
	}
	
	public function ajouter()
	{
		// Définition des règles du formulaire	
		$this->reglesFormulaire();

		if ($this->form_validation->run() == true)
		{
			$this->load->model('statut_model', 'statut');
			if ($this->statut->ajouter($this->input->post('statut')))
				$message = 'Statut ajouté avec succès !';
			else
				$message = 'Erreur lors de l\'ajout du statut.';

			$this->session->set_flashdata('info', $message);
			redirect('/statut', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$donnees['statut'] = array('name' => 'statut',
				'id' => 'statut',
				'type' => 'text',
				'value' => $this->form_validation->set_value('statut'),
			);

			$this->theme->set_titre('Créer un statut');
			$this->theme->view('statut/ajouter', $donnees);
		}
	}
	
	public function modifier($id)
	{
		// Définition des règles du formulaire	
		$this->reglesFormulaire();
		
		if ($this->form_validation->run() == true)
		{
			$this->load->model('statut_model', 'statut');
			if ($this->statut->modifier(intval($id), $this->input->post('statut')))
				$message = 'Modification réalisée avec succès !';
			else
				$message = 'Une erreur s\'est produite lors de la mise à jour du statut.';

			$this->session->set_flashdata('info', $message);
			redirect('/statut', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			$statut = $this->input->post('statut', TRUE);
			if (empty($statut))
			{
				$this->load->model('statut_model', 'statut');
				$statutSelectionne = $this->statut->getStatut(intval($id));
				$val['statut'] = $statutSelectionne->statut_nom;
			}
			else
				$val['statut'] = $this->form_validation->set_value('statut');
				

			$donnees['statut'] = array('name' => 'statut',
				'id' => 'statut',
				'type' => 'text',
				'value' => $val['statut']
			);

			$this->theme->set_titre('Modifier un statut');
			$this->theme->view('statut/modifier', $donnees);
		}
	}
	
	public function supprimer($id)
	{
		$this->load->model('statut_model', 'statut');
		if ($this->statut->supprimer(intval($id)))
			$message = 'Suppression réalisée avec succès !';
		else
			$message = 'Une erreur s\'est produite lors de la suppression du statut.';
			
		$this->session->set_flashdata('info', $message);
		redirect('/statut', 'refresh');
	}
}
