<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Departement extends MY_Controller {

	public function index($tri='', $campus='')
	{
		$this->theme->set_titre('Liste des départements universitaires');
		$this->load->model('departement_model', 'departement');
		$this->load->model('campus_model', 'campus');
		$donnees = array(
			'campus' => $this->campus->listeCampusTri(),
			'departements' => $this->departement->listeDepartements($campus),
		 	'info' => $this->session->flashdata('info'));
		$this->theme->view('departement/index', $donnees);
	}
	
	private function reglesFormulaire()
	{
		$this->form_validation->set_rules('departement', 'Département',
		'trim|required|xss_clean|max_length[50]|min_length[3]'); 
	}
	
	public function ajouter()
	{
		// Définition des règles du formulaire	
		$this->reglesFormulaire();
		$this->load->model('campus_model', 'campus');
		$donnees = array(
			'campus' => $this->campus->listeCampusTri(),
		 	'info' => $this->session->flashdata('info'));

		if ($this->form_validation->run() == true)
		{
			$this->load->model('departement_model', 'departement');
			if ($this->departement->ajouter($this->input->post('departement'),$this->input->post('campus')))
				$message = 'Département ajouté avec succès !';
			else
				$message = 'Erreur lors de l\'ajout du département.';

			$this->session->set_flashdata('info', $message);
			redirect('/departement', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$donnees['departement'] = array('name' => 'departement',
				'id' => 'departement',
				'type' => 'text',
				'value' => $this->form_validation->set_value('departement'),
			);

			$this->theme->set_titre('Créer un département');
			$this->theme->view('departement/ajouter', $donnees);
		}
	}
	
	public function modifier($id)
	{
		// Définition des règles du formulaire	
		$this->reglesFormulaire();
		$this->load->model('campus_model', 'campus');
		
		foreach ($this->campus->listeCampusTri() as $data)
			$lc[$data->campus_id] = $data->campus_nom;
	 
		$donnees = array(
			'listeCampus' => $lc,
		 	'info' => $this->session->flashdata('info'));
		
		if ($this->form_validation->run() == true)
		{
			// Requête de modification
			// Test sur la requête
				// Création d'un flashdata approprié
			// Redirection sur departement/index
			$this->load->model('departement_model', 'departement');
			if ($this->departement->modifier(intval($id),
											$this->input->post('departement'),
											$this->input->post('campus')))
				$message = 'Département modifié avec succès !';
			else
				$message = 'Erreur lors de la modification du département.';

			$this->session->set_flashdata('info', $message);
			redirect('/departement', 'refresh');
		}
		else // Cas par défaut ou en erreur
		{
			$donnees['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$departement = $this->input->post('departement', TRUE);
			if (empty($departement)) // Formulaire non envoyé
			{
				$this->load->model('departement_model', 'departement');
				$deptSelectionne = $this->departement->getDepartement(intval($id));
				$val['departement'] = $deptSelectionne->dept_nom;
				$val['campus'] = $deptSelectionne->dept_campus_id;
			}
			else
			{
				$val['departement'] = $this->form_validation->set_value('departement');
				$val['departement'] = $this->form_validation->set_value('campus');
			}
				

			$donnees['departement'] = array('name' => 'departement',
				'id' => 'departement',
				'type' => 'text',
				'value' => $val['departement']
			);
			$donnees['campus'] = $val['campus'];

			$this->theme->set_titre('Modifier un département');
			$this->theme->view('departement/modifier', $donnees);
		}
	}

	
	public function supprimer($id)
	{
		$this->load->model('departement_model', 'departement');
		if ($this->departement->supprimer(intval($id)))
			$message = 'Suppression réalisée avec succès !';
		else
			$message = 'Une erreur s\'est produite lors de la suppression du statut.';
			
		$this->session->set_flashdata('info', $message);
		redirect('/departement', 'refresh');
	}
}
