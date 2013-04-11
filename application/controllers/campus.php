<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Campus extends MY_Controller {

	public function index()
	{
		$this->theme->set_titre('Liste des campus');
		$this->load->model('campus_model', 'campus');

		$donnees = array(
			'campus' => $this->campus->listeCampus(),
		 	'info' => $this->session->flashdata('info'));
		$this->theme->view('campus/index', $donnees);
	}
	
	private function reglesFormulaire()
	{
		$this->form_validation->set_rules('campus', 'Campus',
		'trim|required|xss_clean|max_length[32]|min_length[3]'); 
	}
	
	public function ajouter()
	{
		// Définition des règles du formulaire	
		$this->reglesFormulaire();

		if ($this->form_validation->run() == true)
		{
			$this->load->model('campus_model', 'campus');
			if ($this->campus->ajouter($this->input->post('campus')))
				$message = 'Campus ajouté avec succès !';
			else
				$message = 'Erreur lors de l\'ajout du campus.';

			$this->session->set_flashdata('info', $message);
			redirect('/campus', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$donnees['statut'] = array('name' => 'campus',
				'id' => 'campus',
				'type' => 'text',
				'value' => $this->form_validation->set_value('campus'),
			);

			$this->theme->set_titre('Créer un campus');
			$this->theme->view('campus/ajouter', $donnees);
		}
	}
	
	public function modifier($id)
	{
		// Définition des règles du formulaire	
		$this->reglesFormulaire();
		
		if ($this->form_validation->run() == true)
		{
			$this->load->model('campus_model', 'campus');
			if ($this->campus->modifier(intval($id), $this->input->post('campus')))
				$message = 'Campus modifié avec succès !';
			else
				$message = 'Erreur lors de la modification du campus.';

			$this->session->set_flashdata('info', $message);
			redirect('/campus', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			
			$campus = $this->input->post('campus', TRUE);
			if (empty($campus))
			{
				$this->load->model('campus_model', 'campus');
				$campusSelectionne = $this->campus->getCampus(intval($id));
				$val['campus'] = $campusSelectionne->campus_nom;
			}
			else
				$val['campus'] = $this->form_validation->set_value('campus');
				

			$donnees['campus'] = array('name' => 'campus',
				'id' => 'campus',
				'type' => 'text',
				'value' => $val['campus']
			);

			$this->theme->set_titre('Modifier un campus');
			$this->theme->view('campus/modifier', $donnees);
		}
	}
	
	public function supprimer($id)
	{
		$this->load->model('campus_model', 'campus');
		if ($this->campus->supprimer(intval($id)))
			$message = 'Suppression réalisée avec succès !';
		else
			$message = 'Une erreur s\'est produite lors de la suppression du campus.';
			
		$this->session->set_flashdata('info', $message);
		redirect('/campus', 'refresh');
	}
}
